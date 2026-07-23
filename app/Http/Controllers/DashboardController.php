<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', [
            'active' => 'dashboard',
            'stats' => [
                [
                    'label' => 'Total Revenus',
                    'value' => '248 500',
                    'unit' => 'DH',
                    'change' => '+12,5%',
                    'up' => true,
                    'card' => 'from-emerald-50 via-white to-teal-100/80 ring-emerald-200/70 shadow-emerald-500/20',
                    'orb' => 'bg-emerald-400/50',
                    'accent' => 'bg-emerald-500',
                    'iconBg' => 'bg-emerald-500 text-white shadow-emerald-500/40',
                    'badge' => 'bg-emerald-500/15 text-emerald-800 ring-emerald-300/50',
                    'icon' => 'M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z',
                ],
                [
                    'label' => 'Total Agences',
                    'value' => '12',
                    'unit' => '',
                    'change' => '+2',
                    'up' => true,
                    'card' => 'from-sky-50 via-white to-blue-100/80 ring-sky-200/70 shadow-sky-500/20',
                    'orb' => 'bg-sky-400/50',
                    'accent' => 'bg-sky-500',
                    'iconBg' => 'bg-sky-500 text-white shadow-sky-500/40',
                    'badge' => 'bg-sky-500/15 text-sky-800 ring-sky-300/50',
                    'icon' => 'M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21',
                ],
                [
                    'label' => 'Nbrs Villes Actives',
                    'value' => '12',
                    'unit' => '',
                    'change' => '+1',
                    'up' => true,
                    'card' => 'from-cyan-50 via-white to-teal-100/80 ring-teal-200/70 shadow-teal-500/20',
                    'orb' => 'bg-teal-400/50',
                    'accent' => 'bg-teal-500',
                    'iconBg' => 'bg-teal-500 text-white shadow-teal-500/40',
                    'badge' => 'bg-teal-500/15 text-teal-800 ring-teal-300/50',
                    'icon' => 'M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z',
                ],
                [
                    'label' => 'Nbrs Clients Actifs',
                    'value' => '186',
                    'unit' => '',
                    'change' => '+8,4%',
                    'up' => true,
                    'card' => 'from-amber-50 via-white to-gold-100/80 ring-gold-200/70 shadow-amber-500/20',
                    'orb' => 'bg-gold-400/50',
                    'accent' => 'bg-gold-500',
                    'iconBg' => 'bg-gold-500 text-white shadow-gold-500/40',
                    'badge' => 'bg-gold-500/15 text-gold-800 ring-gold-300/50',
                    'icon' => 'M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z',
                ],
                [
                    'label' => "Chiffre D'affaire",
                    'value' => '1 042 800',
                    'unit' => 'DH',
                    'change' => '+18,2%',
                    'up' => true,
                    'card' => 'from-navy-50 via-white to-navy-100/90 ring-navy-200/80 shadow-navy-700/20',
                    'orb' => 'bg-navy-500/40',
                    'accent' => 'bg-navy-800',
                    'iconBg' => 'bg-navy-800 text-white shadow-navy-800/40',
                    'badge' => 'bg-navy-800/10 text-navy-800 ring-navy-200/60',
                    'icon' => 'M2.25 18 9 11.25l4.306 4.307a11.95 11.95 0 0 1 5.814-5.519l2.74-1.22m0 0-5.94-2.28m5.94 2.28-2.28 5.941',
                ],
            ],
        ]);
    }

    public function section(string $section)
    {
        $navigation = config('navigation');

        $found = null;
        foreach ($navigation as $group) {
            if (! empty($group['children']) && isset($group['children'][$section])) {
                $found = [
                    'group' => $group['label'],
                    'title' => $group['children'][$section]['label'],
                    'icon' => $group['children'][$section]['icon'],
                ];
                break;
            }
        }

        abort_unless($found, 404);

        return view('dashboard-section', [
            'active' => $section,
            'group' => $found['group'],
            'title' => $found['title'],
            'icon' => $found['icon'],
        ]);
    }
}
