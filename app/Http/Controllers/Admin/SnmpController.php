<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\SnmpService;
use Illuminate\Http\Request;

class SnmpController extends Controller
{
    protected $snmp;

    public function __construct(SnmpService $snmp)
    {
        $this->snmp = $snmp;
    }

    public function index()
    {
        $enabled = $this->snmp->isEnabled();
        $devices = $this->getMonitoredDevices();
        
        return view('admin.snmp.index', compact('enabled', 'devices'));
    }

    public function device($host)
    {
        if (!$this->snmp->isEnabled()) {
            return back()->with('error', 'SNMP tidak aktif');
        }

        $systemInfo = $this->snmp->getSystemInfo($host);
        $interfaces = $this->snmp->getInterfaces($host);
        $resources = $this->snmp->getResourceUsage($host);

        return view('admin.snmp.device', compact('host', 'systemInfo', 'interfaces', 'resources'));
    }

    public function traffic(Request $request)
    {
        $host = $request->get('host');
        $ifIndex = $request->get('interface', 1);

        if (!$this->snmp->isEnabled()) {
            return response()->json(['error' => 'SNMP not enabled']);
        }

        $stats = $this->snmp->getTrafficStats($host, $ifIndex);
        return response()->json($stats);
    }

    public function ping(Request $request)
    {
        $host = $request->get('host');
        $result = $this->snmp->ping($host);
        
        return response()->json(['online' => $result]);
    }


    public function storeDevice(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'host' => 'required|ip',
            'community' => 'nullable|string|max:50',
            'type' => 'required|in:router,switch,olt,server,other',
        ]);

        // Store in settings or database
        $devices = $this->getMonitoredDevices();
        $devices[] = [
            'id' => uniqid(),
            'name' => $request->name,
            'host' => $request->host,
            'community' => $request->community ?? config('services.snmp.community'),
            'type' => $request->type,
            'created_at' => now()->toDateTimeString(),
        ];

        $this->saveMonitoredDevices($devices);

        return back()->with('success', 'Perangkat berhasil ditambahkan');
    }

    public function deleteDevice($id)
    {
        $devices = collect($this->getMonitoredDevices())->filter(fn($d) => $d['id'] !== $id)->values()->all();
        $this->saveMonitoredDevices($devices);

        return back()->with('success', 'Perangkat berhasil dihapus');
    }

    public function dashboard()
    {
        if (!$this->snmp->isEnabled()) {
            return view('admin.snmp.dashboard', ['enabled' => false, 'devices' => []]);
        }

        $devices = $this->getMonitoredDevices();
        $deviceStatus = [];

        foreach ($devices as $device) {
            $deviceStatus[] = [
                'device' => $device,
                'online' => $this->snmp->ping($device['host']),
                'system' => $this->snmp->getSystemInfo($device['host']),
            ];
        }

        return view('admin.snmp.dashboard', [
            'enabled' => true,
            'devices' => $deviceStatus,
        ]);
    }

    protected function getMonitoredDevices(): array
    {
        $path = storage_path('app/snmp_devices.json');
        if (file_exists($path)) {
            return json_decode(file_get_contents($path), true) ?? [];
        }
        return [];
    }

    protected function saveMonitoredDevices(array $devices): void
    {
        file_put_contents(storage_path('app/snmp_devices.json'), json_encode($devices, JSON_PRETTY_PRINT));
    }
}
