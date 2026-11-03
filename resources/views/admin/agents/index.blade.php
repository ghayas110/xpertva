@extends('layouts.dashboard')

@section('title', 'Monitoring Agents')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-slate-800 dark:text-white">Monitoring Agents</h1>
    <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">
        Provision the XpertVA desktop agent on company PCs. Each employee has a unique token — paste it into that machine's
        <code class="text-xs bg-slate-100 dark:bg-slate-700 px-1 py-0.5 rounded">config.json</code>. The agent only records the
        active browser tab during the configured shift window.
    </p>
</div>

@if(session('status'))
<div class="mb-4 rounded-lg bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 px-4 py-3 text-sm text-emerald-700 dark:text-emerald-300">
    {{ session('status') }}
</div>
@endif

<!-- Endpoint reference -->
<div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 p-4 mb-6">
    <p class="text-sm font-medium text-slate-700 dark:text-slate-300 mb-2 flex items-center gap-2">
        <i class="fa-solid fa-plug text-indigo-500"></i> API base URL for agents
    </p>
    <div class="flex items-center gap-2">
        <code id="apiBase" class="flex-1 text-xs sm:text-sm bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg px-3 py-2 text-slate-700 dark:text-slate-200 overflow-x-auto">{{ $apiBase }}</code>
        <button onclick="copyText('{{ $apiBase }}', this)" class="px-3 py-2 bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 rounded-lg text-sm text-slate-700 dark:text-slate-200"><i class="fa-regular fa-copy"></i></button>
    </div>
    <p class="text-xs text-slate-400 mt-2">If <code>APP_URL</code> is still <code>http://localhost</code>, set it to the public URL of this portal before deploying agents.</p>
</div>

<!-- Token table -->
<div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/50">
        <h2 class="font-semibold text-slate-800 dark:text-white flex items-center gap-2">
            <i class="fa-solid fa-key text-slate-400"></i> Employee Agent Tokens
        </h2>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-50 dark:bg-slate-700/50 text-slate-600 dark:text-slate-300 font-medium border-b border-slate-200 dark:border-slate-700">
                <tr>
                    <th class="px-6 py-3">Employee</th>
                    <th class="px-6 py-3">Role</th>
                    <th class="px-6 py-3">Consent</th>
                    <th class="px-6 py-3">Token</th>
                    <th class="px-6 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200 dark:divide-slate-700 text-slate-700 dark:text-slate-300">
                @foreach($users as $user)
                <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50">
                    <td class="px-6 py-3 font-medium text-slate-900 dark:text-white">{{ $user->name }}</td>
                    <td class="px-6 py-3"><span class="text-xs px-2 py-0.5 rounded bg-slate-100 dark:bg-slate-700">{{ $user->role }}</span></td>
                    <td class="px-6 py-3">
                        @if($user->monitoring_consent_at)
                            <span class="text-xs text-emerald-600 dark:text-emerald-400" title="{{ $user->monitoring_consent_at }}"><i class="fa-solid fa-circle-check"></i> Acknowledged</span>
                        @else
                            <span class="text-xs text-slate-400"><i class="fa-regular fa-circle"></i> Pending</span>
                        @endif
                    </td>
                    <td class="px-6 py-3">
                        <div class="flex items-center gap-2">
                            <code class="token text-xs bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded px-2 py-1 font-mono" data-token="{{ $user->agent_token }}">••••••••••••••••</code>
                            <button onclick="toggleToken(this)" class="text-slate-400 hover:text-indigo-500" title="Show/Hide"><i class="fa-regular fa-eye"></i></button>
                            <button onclick="copyText('{{ $user->agent_token }}', this)" class="text-slate-400 hover:text-indigo-500" title="Copy token"><i class="fa-regular fa-copy"></i></button>
                        </div>
                    </td>
                    <td class="px-6 py-3 text-right">
                        <form method="POST" action="{{ route('admin.agents.regenerate', $user) }}" onsubmit="return confirm('Rotate the token for {{ $user->name }}? That machine\'s agent will stop reporting until its config is updated.');" class="inline">
                            @csrf
                            <button type="submit" class="text-xs px-3 py-1.5 rounded-lg bg-amber-50 dark:bg-amber-900/20 text-amber-700 dark:text-amber-400 hover:bg-amber-100 border border-amber-200 dark:border-amber-800">
                                <i class="fa-solid fa-rotate"></i> Regenerate
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
function toggleToken(btn){
    const code = btn.closest('div').querySelector('.token');
    const t = code.getAttribute('data-token');
    if(code.textContent.startsWith('•')){ code.textContent = t; }
    else { code.textContent = '••••••••••••••••'; }
}
function copyText(text, btn){
    navigator.clipboard.writeText(text).then(()=>{
        const i = btn.querySelector('i') || btn;
        const old = i.className;
        i.className = 'fa-solid fa-check text-emerald-500';
        setTimeout(()=> i.className = old, 1200);
    });
}
</script>
@endsection
