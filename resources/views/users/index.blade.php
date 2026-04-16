<x-app-layout>
<div style="margin-bottom:24px;">
    <h1 style="font-size:24px;font-weight:800;color:#111827;margin:0 0 4px;">Utilisateurs</h1>
    <p style="font-size:13px;color:#9ca3af;margin:0;">Découvrez les membres les plus actifs de la communauté</p>
</div>

<div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(240px,1fr));gap:16px;">
    @foreach($users as $user)
        @php
            $ac=['#5046e5','#7c3aed','#059669','#dc2626','#d97706','#0891b2','#c026d3','#0284c7'];
            $ci=abs(crc32($user->name))%count($ac);
        @endphp
        <div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:16px;
                    display:flex;align-items:center;gap:14px;transition:box-shadow .15s, transform .15s;"
             onmouseover="this.style.boxShadow='0 4px 14px rgba(0,0,0,.06)';this.style.transform='translateY(-2px)'"
             onmouseout="this.style.boxShadow='none';this.style.transform='none'">
            <div style="width:48px;height:48px;border-radius:12px;background:{{ $ac[$ci] }};
                        display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <span style="color:#fff;font-weight:800;font-size:18px;">
                    {{ strtoupper(substr($user->name,0,1)) }}
                </span>
            </div>
            <div style="min-width:0;">
                <a href="{{ route('users.show', $user) }}"
                   style="font-size:14px;font-weight:700;color:#1d4ed8;text-decoration:none;
                          display:block;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;"
                   onmouseover="this.style.color='#1e40af'" onmouseout="this.style.color='#1d4ed8'">
                    {{ $user->name }}
                </a>
                <div style="display:flex;align-items:center;gap:6px;margin-top:4px;">
                    <span style="font-size:13px;font-weight:700;color:#5046e5;">{{ number_format($user->reputation) }}</span>
                    <span style="font-size:12px;color:#9ca3af;">pts</span>
                </div>
            </div>
        </div>
    @endforeach
</div>

<div style="margin-top:24px;">
    {{ $users->links() }}
</div>
</x-app-layout>
