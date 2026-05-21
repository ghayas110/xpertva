@extends('layouts.dashboard')

@section('content')
<div class="h-[calc(100vh-64px)] -m-4 sm:-m-6 lg:-m-8 bg-slate-50 dark:bg-slate-900 border-t border-slate-200 dark:border-slate-700 flex flex-col overflow-hidden">
    
    @if(!$emailAccount)
        <!-- UNINTEGRATED STATE: CONFIGURATION VIEW -->
        <div class="flex-1 flex items-center justify-center p-4 bg-gradient-to-br from-slate-50 to-indigo-50 dark:from-slate-900 dark:to-slate-800">
            <div class="bg-white dark:bg-slate-800 rounded-2xl w-full max-w-[420px] shadow-xl border border-slate-200 dark:border-slate-700 overflow-hidden">

                <!-- Header with XpertVA branding -->
                <div class="bg-indigo-600 px-8 py-8 text-center">
                    <div class="flex justify-center mb-3">
                        <img src="{{ asset('assets/images/logo-xpertva.png') }}" alt="XpertVA" class="h-12 w-12 object-contain rounded-xl bg-white/20 p-1.5">
                    </div>
                    <h1 class="text-white text-2xl font-bold tracking-tight">XpertVA Mail</h1>
                    <p class="text-indigo-200 text-sm mt-1">Connect your email account to get started</p>
                </div>

                <!-- Form -->
                <div class="px-8 py-8">
                    <form id="native-login-form" onsubmit="event.preventDefault(); submitWebmailConfig();" class="space-y-5">

                        <!-- Email -->
                        <div>
                            <label for="wm_email" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Email Address</label>
                            <div class="relative">
                                <i class="fa-regular fa-envelope absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                                <input type="email" name="email" id="wm_email" required autocomplete="off"
                                    class="block w-full pl-10 pr-4 py-2.5 bg-slate-50 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-lg shadow-sm text-slate-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm transition-colors"
                                    placeholder="you@example.com">
                            </div>
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="wm_password" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Password</label>
                            <div class="relative">
                                <i class="fa-solid fa-lock absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                                <input type="password" name="password" id="wm_password" required autocomplete="new-password"
                                    class="block w-full pl-10 pr-10 py-2.5 bg-slate-50 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-lg shadow-sm text-slate-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm transition-colors"
                                    placeholder="Enter your email password">
                                <button type="button" id="togglePwd" onclick="togglePasswordVisibility()"
                                        class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition-colors">
                                    <i id="eyeIcon" class="fa-regular fa-eye text-sm"></i>
                                </button>
                            </div>
                            <p class="text-xs text-slate-400 dark:text-slate-500 mt-1.5">Use your SiteGround email app password or IMAP password.</p>
                        </div>

                        <!-- Messages -->
                        <div id="errorMessage" class="hidden flex items-start gap-2 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-400 text-sm p-3 rounded-lg">
                            <i class="fa-solid fa-circle-exclamation mt-0.5 shrink-0"></i>
                            <span id="errorText"></span>
                        </div>
                        <div id="successMessage" class="hidden flex items-start gap-2 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-400 text-sm p-3 rounded-lg">
                            <i class="fa-solid fa-circle-check mt-0.5 shrink-0"></i>
                            <span id="successText"></span>
                        </div>

                        <button type="submit" id="submitBtn"
                                class="w-full flex justify-center items-center gap-2 py-2.5 px-6 bg-indigo-600 hover:bg-indigo-700 disabled:opacity-50 text-white font-semibold text-sm rounded-lg transition-colors shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                            <svg id="submitSpinner" class="animate-spin h-4 w-4 text-white hidden" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span id="submitText">Connect Email</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <script>
            function togglePasswordVisibility() {
                const input = document.getElementById('wm_password');
                const icon  = document.getElementById('eyeIcon');
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.className = 'fa-regular fa-eye-slash text-sm';
                } else {
                    input.type = 'password';
                    icon.className = 'fa-regular fa-eye text-sm';
                }
            }

            async function submitWebmailConfig() {
                const btn     = document.getElementById('submitBtn');
                const spinner = document.getElementById('submitSpinner');
                const text    = document.getElementById('submitText');
                const errBox  = document.getElementById('errorMessage');
                const errText = document.getElementById('errorText');
                const succBox = document.getElementById('successMessage');
                const succText= document.getElementById('successText');
                const email   = document.getElementById('wm_email').value;
                const password= document.getElementById('wm_password').value;

                btn.disabled = true;
                spinner.classList.remove('hidden');
                text.innerText = 'Connecting...';
                errBox.classList.add('hidden');
                succBox.classList.add('hidden');

                try {
                    const response = await fetch('{{ route('webmail.save-config') }}', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') },
                        body: JSON.stringify({ email, password })
                    });
                    const data = await response.json();
                    if (data.success) {
                        succText.innerText = 'Connected successfully! Loading your inbox...';
                        succBox.classList.remove('hidden');
                        setTimeout(() => window.location.reload(), 1500);
                    } else {
                        errText.innerText = data.message || 'Failed to connect. Please check your credentials.';
                        errBox.classList.remove('hidden');
                        btn.disabled = false;
                        spinner.classList.add('hidden');
                        text.innerText = 'Connect Email';
                    }
                } catch (error) {
                    errText.innerText = 'Network error: ' + error.message;
                    errBox.classList.remove('hidden');
                    btn.disabled = false;
                    spinner.classList.add('hidden');
                    text.innerText = 'Connect Email';
                }
            }
        </script>
    @else
        <!-- INTEGRATED STATE: GMAIL-LIKE UI -->
        <div class="flex-1 flex overflow-hidden bg-white dark:bg-[#1a1a1a]">

            <!-- LEFT SIDEBAR -->
            <div class="w-[256px] flex flex-col pt-3">
                <div class="px-3 pb-4">
                    <button onclick="openComposeModal()" class="bg-[#c2e7ff] hover:bg-[#b3dcf6] text-[#001d35] shadow-[0_1px_2px_0_rgba(60,64,67,0.3),0_1px_3px_1px_rgba(60,64,67,0.15)] rounded-2xl px-5 py-4 font-medium flex items-center transition-all">
                        <i class="fa-solid fa-pen mr-4"></i>
                        <span class="text-[0.875rem] tracking-wide">Compose</span>
                    </button>
                </div>
                
                <nav class="flex-1 overflow-y-auto text-[#202124] dark:text-[#e8eaed] text-[0.875rem] font-medium pr-3">
                    <button id="folder-INBOX" onclick="changeFolder('INBOX')" class="folder-btn w-full flex items-center px-6 py-2 rounded-r-full transition-colors mt-1 hover:bg-slate-100 dark:hover:bg-slate-800">
                        <i class="fa-solid fa-inbox w-5 text-center mr-4"></i> Inbox
                    </button>
                    <button id="folder-Drafts" onclick="changeFolder('Drafts')" class="folder-btn w-full flex items-center px-6 py-2 rounded-r-full transition-colors mt-1 hover:bg-slate-100 dark:hover:bg-slate-800">
                        <i class="fa-solid fa-file w-5 text-center mr-4"></i> Drafts
                    </button>
                    <button id="folder-Sent" onclick="changeFolder('Sent')" class="folder-btn w-full flex items-center px-6 py-2 rounded-r-full transition-colors mt-1 hover:bg-slate-100 dark:hover:bg-slate-800">
                        <i class="fa-solid fa-paper-plane w-5 text-center mr-4"></i> Sent
                    </button>
                    <button id="folder-Trash" onclick="changeFolder('Trash')" class="folder-btn w-full flex items-center px-6 py-2 rounded-r-full transition-colors mt-1 hover:bg-slate-100 dark:hover:bg-slate-800">
                        <i class="fa-solid fa-trash w-5 text-center mr-4"></i> Trash
                    </button>
                </nav>
            </div>

            <!-- MAIN LIST / PANE VIEW -->
            <div class="flex-1 flex flex-col bg-white dark:bg-[#1a1a1a] rounded-xl mr-4 mb-4 overflow-hidden relative" style="box-shadow: 0 1px 2px 0 rgba(60,64,67,0.3), 0 1px 3px 1px rgba(60,64,67,0.15); background: #f2f6fc;">
                
                <!-- HEADER (Search & Actions) -->
                <div class="p-2 border-b border-transparent flex justify-between items-center z-10 sticky top-0 bg-[#f2f6fc]">
                    <div class="flex items-center space-x-2 w-full max-w-[720px] bg-[#eaf1fb] px-4 py-2 rounded-full mx-2">
                        <i class="fa-solid fa-magnifying-glass text-slate-500"></i>
                        <input type="text" placeholder="Search in mail" class="bg-transparent border-none outline-none w-full text-sm text-slate-800 placeholder-slate-500 focus:ring-0">
                        <i class="fa-solid fa-sliders text-slate-500 cursor-pointer"></i>
                    </div>
                    
                    <div class="flex items-center space-x-2 mr-4 text-slate-500">
                        <button onclick="fetchMails()" class="hover:bg-slate-200 p-2 rounded-full transition-colors" title="Refresh">
                            <i id="refreshIcon" class="fa-solid fa-rotate-right"></i>
                        </button>
                        
                        <div class="relative">
                            <button onclick="toggleSettings()" class="hover:bg-slate-200 p-2 rounded-full transition-colors" title="Settings">
                                <i class="fa-solid fa-gear"></i>
                            </button>
                            <div id="settingsMenu" class="hidden absolute right-0 mt-2 w-48 bg-white dark:bg-slate-800 rounded-md shadow-lg border border-slate-200 dark:border-slate-700 z-50 overflow-hidden">
                                <button onclick="disconnectEmail()" class="w-full text-left px-4 py-3 text-sm text-red-600 hover:bg-slate-100 font-medium flex items-center">
                                    <i class="fa-solid fa-arrow-right-from-bracket w-5"></i> Log out
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex items-center px-4 py-2 bg-white rounded-t-xl mx-0 mt-2 border-b border-gray-100">
                    <button class="text-sm font-semibold text-slate-700 px-2 py-1"><i class="fa-regular fa-square mr-3"></i> <i class="fa-solid fa-caret-down text-xs"></i></button>
                </div>

                <!-- LOADING SPINNER -->
                <div id="loadingSpinner" class="hidden absolute inset-0 z-20 bg-white/50 backdrop-blur-sm flex-col items-center justify-center pointer-events-none mt-[100px]">
                    <svg class="animate-spin h-8 w-8 text-[#1a73e8] mb-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    <p class="text-slate-600 font-medium text-sm">Loading...</p>
                    <p id="fetchErrorMsg" class="hidden text-red-500 text-xs mt-2 text-center max-w-sm"></p>
                </div>

                <!-- EMAIL LIST -->
                <div id="emailList" class="flex-1 overflow-y-auto bg-white"></div>
                
                <div id="emptyListMessage" class="hidden p-8 text-center text-slate-500 text-sm bg-white">
                    Your <span id="currentFolderName">INBOX</span> is empty.
                </div>

                <!-- EMAIL READING PANE -->
                <div id="emailReadingPane" class="hidden flex-1 overflow-y-auto p-8 bg-white">
                    <div class="mb-6 flex items-center space-x-4">
                        <button onclick="closeEmail()" title="Back to inbox" class="text-slate-500 hover:bg-slate-100 p-2 rounded-full transition-colors">
                            <i class="fa-solid fa-arrow-left"></i>
                        </button>
                        <h2 id="viewSubject" class="text-[1.375rem] font-normal text-slate-900"></h2>
                    </div>
                    
                    <div class="flex items-start justify-between mb-8 pb-4">
                        <div class="flex items-center">
                            <div id="viewAvatar" class="w-10 h-10 rounded-full bg-gradient-to-br from-[#1a73e8] to-[#174ea6] flex items-center justify-center text-white font-medium mr-4 text-xl capitalize shrink-0 shadow-sm"></div>
                            <div>
                                <div class="flex space-x-2 items-baseline">
                                    <div id="viewFromName" class="font-bold text-[0.875rem] text-[#202124]"></div>
                                    <div id="viewFromEmail" class="text-xs text-slate-500"></div>
                                </div>
                                <div class="text-xs text-slate-500 flex items-center space-x-1 mt-1">
                                    <span>to me</span>
                                    <i class="fa-solid fa-caret-down"></i>
                                </div>
                            </div>
                        </div>
                        <div class="text-xs text-slate-500 flex items-center space-x-4">
                            <span id="viewDate"></span>
                            <button type="button" onclick="openReplyModal()" title="Reply" class="hover:bg-slate-100 p-1.5 rounded-full transition-colors">
                                <i class="fa-solid fa-reply"></i>
                            </button>
                        </div>
                    </div>
                    <!-- Email Body -->
                    <iframe id="viewBodyFrame" class="w-full border-none ml-14" style="min-height: 400px;" sandbox="allow-same-origin allow-popups allow-popups-to-escape-sandbox allow-downloads"></iframe>
                </div>
            </div>
            
            <!-- COMPOSE MODAL -->
            <div id="composeModal" class="hidden fixed bottom-0 right-24 w-[500px] h-[500px] bg-white rounded-t-[8px] shadow-[0_8px_10px_1px_rgba(0,0,0,0.14),0_3px_14px_2px_rgba(0,0,0,0.12),0_5px_5px_-3px_rgba(0,0,0,0.2)] flex flex-col overflow-hidden z-50 transform origin-bottom">
                <!-- Header -->
                <div class="bg-[#f2f6fc] text-[#041e49] px-4 py-2 flex justify-between items-center cursor-pointer rounded-t-[8px]">
                    <span class="font-medium text-sm">New Message</span>
                    <div class="flex space-x-3 text-slate-500">
                        <button class="hover:bg-slate-200 px-1 rounded transition-colors"><i class="fa-solid fa-minus"></i></button>
                        <button class="hover:bg-slate-200 px-1 rounded transition-colors" style="font-size: 11px;"><i class="fa-solid fa-up-right-and-down-left-from-center"></i></button>
                        <button onclick="closeComposeModal()" class="hover:bg-slate-200 px-1 rounded transition-colors"><i class="fa-solid fa-xmark"></i></button>
                    </div>
                </div>
                <!-- Body -->
                <div class="flex-1 flex flex-col pt-0 overflow-hidden relative border-l border-r border-[#dadce0]">
                    <form id="composeForm" onsubmit="event.preventDefault(); sendMail();" class="flex flex-col h-full bg-white">
                        <div class="border-b border-[#f2f2f4] flex flex-col justify-end px-4 min-h-[40px]">
                            <input type="email" id="composeTo" placeholder="To" required class="w-full py-1 bg-transparent border-none focus:ring-0 text-[0.875rem] text-[#202124] placeholder-slate-500 focus:outline-none">
                        </div>
                        <div class="border-b border-[#f2f2f4] flex flex-col justify-end px-4 min-h-[40px]">
                            <input type="text" id="composeSubject" placeholder="Subject" required class="w-full py-1 bg-transparent border-none focus:ring-0 text-[0.875rem] text-[#202124] placeholder-slate-500 focus:outline-none">
                        </div>
                        <!-- Rich text body (contenteditable so we can embed images and links) -->
                        <div id="composeBody" contenteditable="true" data-placeholder="Write your message here..."
                             class="flex-1 px-4 py-2 text-[0.875rem] text-[#202124] outline-none overflow-y-auto compose-body-placeholder"
                             style="min-height: 100px;"></div>

                        <!-- Hidden file input (any type) -->
                        <input type="file" id="composeFileInput" multiple class="hidden" onchange="handleComposeFiles(event)">

                        <!-- Attached files list -->
                        <div id="composeAttachments" class="hidden px-4 py-2 border-t border-[#f2f2f4] flex flex-wrap gap-2"></div>

                        <!-- Error Message -->
                        <div id="composeErrorBox" class="hidden mx-2 mb-2 p-2 bg-red-100 text-red-700 text-xs rounded"></div>

                        <!-- Footer -->
                        <div class="p-3 border-t border-[#f2f2f4] flex items-center justify-between bg-white rounded-b-xl">
                            <div class="flex items-center">
                                <button type="submit" id="btnSendMail" class="bg-[#0b57d0] hover:bg-[#0842a0] disabled:opacity-50 text-white shadow-sm rounded-full px-6 py-2 font-medium text-sm transition-colors flex items-center">
                                    <svg id="composeSpinner" class="hidden animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                    <span id="composeBtnText">Send</span>
                                </button>
                                <div class="w-px h-6 bg-slate-200 mx-3"></div>
                                <button type="button" onclick="composeBold()" title="Bold" class="px-2 py-1 hover:bg-slate-100 rounded text-slate-600 transition-colors">
                                    <i class="fa-solid fa-bold text-sm"></i>
                                </button>
                                <button type="button" onclick="document.getElementById('composeFileInput').click()" title="Attach file" class="px-2 py-1 hover:bg-slate-100 rounded text-slate-600 transition-colors ml-1">
                                    <i class="fa-solid fa-paperclip text-sm"></i>
                                </button>
                                <button type="button" onclick="composeInsertLink()" title="Insert link" class="px-2 py-1 hover:bg-slate-100 rounded text-slate-600 transition-colors ml-1">
                                    <i class="fa-solid fa-link text-sm"></i>
                                </button>
                            </div>
                            <button type="button" onclick="closeComposeModal()" class="text-slate-500 hover:text-slate-700 p-2" title="Discard"><i class="fa-solid fa-trash"></i></button>
                        </div>
                    </form>
                </div>
            </div>

        </div>

        <style>
            .compose-body-placeholder:empty:before {
                content: attr(data-placeholder);
                color: #9ca3af;
                pointer-events: none;
            }
            #composeBody img { max-width: 100%; height: auto; display: block; margin: 4px 0; }
            #composeBody a   { color: #1a73e8; text-decoration: underline; }
            #composeBody b, #composeBody strong { font-weight: 700; }
        </style>

        <script>
            let currentFolder = 'INBOX';
            let activeEmails = [];
            let isLoading = false;
            let selectedEmails = new Set();
            let starredEmails = new Set();
            let currentOpenMail = null;

            document.addEventListener('DOMContentLoaded', () => {
                updateSidebarUI();
                fetchMails();
            });

            function toggleSettings() {
                const el = document.getElementById('settingsMenu');
                if (el.classList.contains('hidden')) {
                    el.classList.remove('hidden');
                } else {
                    el.classList.add('hidden');
                }
            }

            function openComposeModal() {
                document.getElementById('composeModal').classList.remove('hidden');
            }

            function closeComposeModal() {
                document.getElementById('composeModal').classList.add('hidden');
                if (typeof resetComposeAttachments === 'function') resetComposeAttachments();
            }

            function changeFolder(folder) {
                if (currentFolder === folder) return;
                currentFolder = folder;
                updateSidebarUI();
                fetchMails();
            }

            function updateSidebarUI() {
                document.querySelectorAll('.folder-btn').forEach(el => {
                    el.className = 'folder-btn w-full flex items-center px-6 py-2 rounded-r-full transition-colors mt-1 hover:bg-slate-100 dark:hover:bg-slate-800 text-[#202124] dark:text-[#e8eaed]';
                });
                const activeBtn = document.getElementById('folder-' + currentFolder);
                if (activeBtn) {
                    activeBtn.className = 'folder-btn w-full flex items-center px-6 py-2 rounded-r-full transition-colors ' + "bg-[#d3e3fd] text-[#041e49] font-bold mt-1";
                }
                document.getElementById('currentFolderName').innerText = currentFolder;
                closeEmail();
            }

            async function fetchMails() {
                if (isLoading) return;
                isLoading = true;
                
                const spinner = document.getElementById('loadingSpinner');
                const list = document.getElementById('emailList');
                const emptyMsg = document.getElementById('emptyListMessage');
                const errorMsg = document.getElementById('fetchErrorMsg');
                const refreshIcon = document.getElementById('refreshIcon');

                errorMsg.classList.add('hidden');
                list.innerHTML = '';
                emptyMsg.classList.add('hidden');
                spinner.classList.remove('hidden');
                spinner.classList.add('flex');
                refreshIcon.classList.add('animate-spin');

                try {
                    const fetchUrl = `{{ route('webmail.fetch') }}?folder=${encodeURIComponent(currentFolder)}&limit=200`;
                    const response = await fetch(fetchUrl, { headers: { 'Accept': 'application/json' } });
                    const data = await response.json();
                    console.log(data, "data");
                    
                    if (data.success) {
                        activeEmails = data.messages;
                        renderList();
                    } else {
                        errorMsg.innerText = data.message || "Failed to fetch emails from server.";
                        errorMsg.classList.remove('hidden');
                    }
                } catch (e) {
                    errorMsg.innerText = "Network timeout or connection refused.";
                    errorMsg.classList.remove('hidden');
                } finally {
                    isLoading = false;
                    spinner.classList.add('hidden');
                    spinner.classList.remove('flex');
                    refreshIcon.classList.remove('animate-spin');
                }
            }

            function escapeHtml(unsafe) {
                if(!unsafe) return '';
                return unsafe
                     .replace(/&/g, "&amp;")
                     .replace(/</g, "&lt;")
                     .replace(/>/g, "&gt;")
                     .replace(/"/g, "&quot;")
                     .replace(/'/g, "&#039;");
            }

            function renderList() {
                const list = document.getElementById('emailList');
                list.innerHTML = '';
                
                if (activeEmails.length === 0) {
                    document.getElementById('emptyListMessage').classList.remove('hidden');
                    return;
                }
                
                activeEmails.forEach((mail, index) => {
                    const isUnread = !mail.flags.seen;
                    const isSelected = selectedEmails.has(mail.id);
                    const isStarred = starredEmails.has(mail.id);
                    const bgClass = isSelected ? 'bg-[#c2dbff]' : (isUnread ? 'bg-white' : 'bg-[#f2f6fc] text-slate-600');
                    const textClass = isUnread ? 'font-bold text-[#202124]' : 'text-slate-600';
                    const dateClass = isUnread ? 'font-bold text-[#202124]' : 'text-slate-500';
                    const checkIcon = isSelected ? 'fa-solid fa-square-check text-[#1a73e8]' : 'fa-regular fa-square text-slate-300 hover:text-slate-500';
                    const starIcon = isStarred ? 'fa-solid fa-star text-[#f4b400]' : 'fa-regular fa-star text-slate-300 hover:text-[#f4b400]';
                    
                    const row = document.createElement('div');
                    row.className = `flex items-center px-4 py-0 hover:shadow-[inset_1px_0_0_#dadce0,inset_-1px_0_0_#dadce0,0_1px_2px_0_rgba(60,64,67,0.3),0_1px_3px_1px_rgba(60,64,67,0.15)] hover:z-10 border-b border-[#f2f2f4] cursor-pointer transition-shadow min-h-[40px] ${bgClass}`;
                    row.onclick = (e) => { if (!e.target.closest('.mail-action-btn')) openEmail(index); };
                    
                    row.innerHTML = `
                        <div class="flex items-center w-[250px] shrink-0">
                            <button class="mail-action-btn p-1 mr-2" onclick="event.stopPropagation(); toggleSelect(${index})">
                                <i class="${checkIcon}"></i>
                            </button>
                            <button class="mail-action-btn p-1 mr-2" onclick="event.stopPropagation(); toggleStar(${index})">
                                <i class="${starIcon}"></i>
                            </button>
                            <span class="text-[0.875rem] truncate ${textClass}">${escapeHtml(mail.from_name)}</span>
                        </div>
                        <div class="flex-1 text-[0.875rem] truncate px-4">
                            <span class="mr-2 ${textClass}">${escapeHtml(mail.subject)}</span>
                            <span class="text-slate-500">- ${escapeHtml(mail.snippet)}</span>
                        </div>
                        <div class="text-xs w-24 text-right pr-4 ${dateClass}">${escapeHtml(mail.date)}</div>
                    `;
                    list.appendChild(row);
                });
            }

            function toggleSelect(index) {
                const mail = activeEmails[index];
                if (selectedEmails.has(mail.id)) {
                    selectedEmails.delete(mail.id);
                } else {
                    selectedEmails.add(mail.id);
                }
                renderList();
            }

            function toggleStar(index) {
                const mail = activeEmails[index];
                if (starredEmails.has(mail.id)) {
                    starredEmails.delete(mail.id);
                } else {
                    starredEmails.add(mail.id);
                }
                renderList();
            }

            function openReplyModal() {
                const mail = currentOpenMail;
                if (!mail) {
                    alert('Open an email first to reply.');
                    return;
                }
                const replyTo = mail.reply_to || mail.from;
                const subject = mail.subject && mail.subject.match(/^Re:/i) ? mail.subject : 'Re: ' + (mail.subject || '');
                document.getElementById('composeTo').value = replyTo || '';
                document.getElementById('composeSubject').value = subject;
                document.getElementById('composeBody').innerHTML = '';
                if (typeof resetComposeAttachments === 'function') resetComposeAttachments();
                openComposeModal();
                setTimeout(() => document.getElementById('composeBody').focus(), 50);
            }

            /* ─── Compose rich-text helpers ─── */
            function composeBold() {
                document.getElementById('composeBody').focus();
                document.execCommand('bold', false, null);
            }

            function composeInsertLink() {
                const url = prompt('Enter URL (e.g. https://example.com):');
                if (!url) return;
                const body = document.getElementById('composeBody');
                body.focus();
                const sel = window.getSelection();
                if (sel && sel.toString().length > 0) {
                    document.execCommand('createLink', false, url);
                } else {
                    // No selection — insert the URL as both text and href
                    document.execCommand('insertHTML', false,
                        `<a href="${url}" target="_blank">${url}</a>`);
                }
            }

            /* ─── File attachment handling ─── */
            let composeAttachments = [];

            function handleComposeFiles(e) {
                const files = Array.from(e.target.files || []);
                files.forEach(f => composeAttachments.push(f));
                renderComposeAttachments();
                e.target.value = '';
            }

            function renderComposeAttachments() {
                const wrap = document.getElementById('composeAttachments');
                wrap.innerHTML = '';
                if (composeAttachments.length === 0) {
                    wrap.classList.add('hidden');
                    return;
                }
                wrap.classList.remove('hidden');
                composeAttachments.forEach((f, idx) => {
                    const sizeKb = (f.size / 1024).toFixed(1);
                    const chip = document.createElement('div');
                    chip.className = 'inline-flex items-center gap-2 bg-[#e8f0fe] text-[#1a73e8] text-xs px-3 py-1.5 rounded-full';
                    chip.innerHTML =
                        `<i class="fa-solid fa-paperclip text-xs"></i>` +
                        `<span class="max-w-[160px] truncate" title="${f.name.replace(/"/g, '&quot;')}">${f.name}</span>` +
                        `<span class="text-slate-500">${sizeKb} KB</span>` +
                        `<button type="button" onclick="removeComposeAttachment(${idx})" class="ml-1 text-slate-500 hover:text-red-600"><i class="fa-solid fa-xmark text-xs"></i></button>`;
                    wrap.appendChild(chip);
                });
            }

            function removeComposeAttachment(idx) {
                composeAttachments.splice(idx, 1);
                renderComposeAttachments();
            }

            function resetComposeAttachments() {
                composeAttachments = [];
                renderComposeAttachments();
            }

            function openEmail(index) {
                const mail = activeEmails[index];
                currentOpenMail = mail;
                document.getElementById('emailList').classList.add('hidden');
                document.getElementById('emailReadingPane').classList.remove('hidden');
                
                document.getElementById('viewSubject').innerText = mail.subject;
                document.getElementById('viewAvatar').innerText = mail.from_name.substring(0, 1).toUpperCase();
                document.getElementById('viewFromName').innerText = mail.from_name;
                document.getElementById('viewFromEmail').innerText = '<' + mail.from + '>';
                document.getElementById('viewDate').innerText = mail.date;

                // Render body in sandboxed iframe so images load properly
                const iframe = document.getElementById('viewBodyFrame');
                const doc = iframe.contentDocument || iframe.contentWindow.document;
                doc.open();
                doc.write(`
                    <!DOCTYPE html>
                    <html>
                    <head>
                        <meta charset="utf-8">
                        <style>
                            body { font-family: 'Google Sans', Roboto, Arial, sans-serif; font-size: 14px; color: #202124; line-height: 1.6; margin: 0; padding: 0; }
                            img { max-width: 100%; height: auto; display: inline-block; }
                            a { color: #1a73e8; }
                        </style>
                    </head>
                    <body>${mail.body || '<p>No content</p>'}</body>
                    </html>
                `);
                doc.close();

                // Auto-resize iframe to content height
                iframe.onload = function() {
                    try {
                        iframe.style.height = iframe.contentDocument.body.scrollHeight + 40 + 'px';
                    } catch(e) {}
                };
                setTimeout(() => {
                    try {
                        iframe.style.height = iframe.contentDocument.body.scrollHeight + 40 + 'px';
                    } catch(e) {}
                }, 500);

                // Mark as seen — locally for immediate UI feedback, and on the
                // server so the seen state survives refreshes/sessions.
                if (!mail.flags.seen) {
                    mail.flags.seen = true;
                    fetch('{{ route('webmail.mark-seen') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ uid: mail.id, folder: currentFolder })
                    }).catch(() => {});
                }
            }

            function closeEmail() {
                document.getElementById('emailReadingPane').classList.add('hidden');
                document.getElementById('emailList').classList.remove('hidden');
                currentOpenMail = null;
                renderList();
            }

            async function sendMail() {
                const btn      = document.getElementById('btnSendMail');
                const spinner  = document.getElementById('composeSpinner');
                const btnText  = document.getElementById('composeBtnText');
                const errorBox = document.getElementById('composeErrorBox');

                const to      = document.getElementById('composeTo').value.trim();
                const subject = document.getElementById('composeSubject').value.trim();
                const bodyEl  = document.getElementById('composeBody');
                const body    = bodyEl.innerHTML.trim();

                errorBox.classList.add('hidden');

                if (!to || !subject) {
                    errorBox.innerText = 'Please fill in To and Subject.';
                    errorBox.classList.remove('hidden');
                    return;
                }
                if (!body || body === '<br>') {
                    errorBox.innerText = 'Message body cannot be empty.';
                    errorBox.classList.remove('hidden');
                    return;
                }

                btn.disabled = true;
                spinner.classList.remove('hidden');
                btnText.innerText = 'Sending...';

                try {
                    const fd = new FormData();
                    fd.append('to', to);
                    fd.append('subject', subject);
                    fd.append('body', body);
                    composeAttachments.forEach(f => fd.append('attachments[]', f, f.name));

                    const response = await fetch('{{ route('webmail.send') }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json'
                        },
                        body: fd
                    });
                    const data = await response.json();

                    if (data.success) {
                        document.getElementById('composeTo').value = '';
                        document.getElementById('composeSubject').value = '';
                        bodyEl.innerHTML = '';
                        resetComposeAttachments();
                        closeComposeModal();
                        // Refresh after a short delay so server-side Sent append has time to land
                        setTimeout(() => fetchMails(), 1500);
                        showToast("Message sent.");
                    } else {
                        errorBox.innerText = data.message || 'Failed to send message.';
                        errorBox.classList.remove('hidden');
                    }
                } catch (error) {
                    errorBox.innerText = 'A network error occurred: ' + error.message;
                    errorBox.classList.remove('hidden');
                } finally {
                    btn.disabled = false;
                    spinner.classList.add('hidden');
                    btnText.innerText = 'Send';
                }
            }

            async function disconnectEmail() {
                if(!confirm("Are you sure you want to disconnect this email account?")) return;
                try {
                    const response = await fetch('{{ route('webmail.disconnect') }}', {
                        method: 'POST',
                        headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') }
                    });
                    if (response.ok) { window.location.reload(); }
                } catch (e) {
                    console.error("Disconnect failed", e);
                }
            }

            function showToast(message) {
                let toast = document.getElementById('webmailToast');
                if (!toast) {
                    toast = document.createElement('div');
                    toast.id = 'webmailToast';
                    toast.className = 'fixed bottom-6 left-6 bg-[#323232] text-white px-6 py-3 rounded shadow-lg text-[0.875rem] font-medium z-[100] transition-all duration-300 opacity-0 transform translate-y-4 flex items-center';
                    document.body.appendChild(toast);
                }
                
                // Set message and icon
                toast.innerHTML = `<i class="fa-solid fa-check text-green-400 mr-3"></i> ${message}`;
                
                // Trigger animation
                toast.classList.remove('opacity-0', 'translate-y-4');
                toast.classList.add('opacity-100', 'translate-y-0');
                
                // Hide after 4 seconds
                setTimeout(() => {
                    toast.classList.remove('opacity-100', 'translate-y-0');
                    toast.classList.add('opacity-0', 'translate-y-4');
                }, 4000);
            }
        </script>
    @endif
</div>
@endsection
