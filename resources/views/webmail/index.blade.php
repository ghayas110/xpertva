@extends('layouts.dashboard')

@section('content')
<div class="h-[calc(100vh-64px)] -m-4 sm:-m-6 lg:-m-8 bg-slate-50 dark:bg-slate-900 border-t border-slate-200 dark:border-slate-700 flex flex-col overflow-hidden">
    
    @if(!$emailAccount)
        <!-- UNINTEGRATED STATE: CONFIGURATION VIEW -->
        <div class="flex-1 flex items-center justify-center p-4 bg-[#f0f4f9] dark:bg-slate-900 border-none">
            <div class="bg-white dark:bg-slate-800 rounded-3xl w-full max-w-[450px] p-10 mt-10" style="padding: 40px; box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);">
                <div class="text-center mb-8">
                    <div class="mb-4 flex justify-center">
                        <svg viewBox="0 0 75 24" width="75" height="24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" class="l5Lhkf"><g id="qaEJec"><path fill="#ea4335" d="M67.954 16.303c-1.33 0-2.278-.608-2.886-1.804l7.967-3.3-.27-.68c-.495-1.33-2.008-3.79-5.102-3.79-3.068 0-5.622 2.41-5.622 5.96 0 3.34 2.53 5.96 5.92 5.96 2.73 0 4.31-1.67 4.97-2.64l-2.03-1.35c-.673.98-1.6 1.64-2.93 1.64zm-.203-7.27c1.04 0 1.92.52 2.21 1.264l-5.32 2.21c-.06-2.3 1.79-3.474 3.12-3.474z"></path></g><g id="YGlOvc"><path fill="#34a853" d="M58.193.67h2.564v17.44h-2.564z"></path></g><g id="BWfIk"><path fill="#4285f4" d="M54.152 8.066h-.088c-.588-.697-1.716-1.33-3.136-1.33-2.98 0-5.71 2.614-5.71 5.98 0 3.338 2.73 5.933 5.71 5.933 1.42 0 2.548-.64 3.136-1.36h.088v.86c0 2.28-1.217 3.5-3.183 3.5-1.61 0-2.6-1.15-3-2.12l-2.28.94c.65 1.58 2.39 3.52 5.28 3.52 3.06 0 5.66-1.807 5.66-6.206V7.21h-2.5v.858zm-2.88 9.693c-1.898 0-3.388-1.54-3.388-3.44 0-1.92 1.49-3.46 3.38-3.46 1.9 0 3.44 1.54 3.44 3.46 0 1.9-1.54 3.44-3.44 3.44z"></path></g><g id="e6K1"><path fill="#fbbc05" d="M38.17 6.735c-3.28 0-5.953 2.506-5.953 5.96 0 3.432 2.673 5.96 5.954 5.96 3.33 0 5.96-2.528 5.96-5.96 0-3.46-2.63-5.96-5.96-5.96zm0 9.568c-1.798 0-3.434-1.46-3.434-3.608 0-2.14 1.636-3.6 3.433-3.6 1.77 0 3.433 1.46 3.433 3.6 0 2.14-1.663 3.6-3.433 3.6z"></path></g><g id="JJ0eO"><path fill="#ea4335" d="M25.17 6.735c-3.28 0-5.954 2.506-5.954 5.96 0 3.432 2.673 5.96 5.954 5.96 3.33 0 5.96-2.528 5.96-5.96 0-3.46-2.63-5.96-5.96-5.96zm0 9.568c-1.798 0-3.434-1.46-3.434-3.608 0-2.14 1.636-3.6 3.433-3.6 1.77 0 3.433 1.46 3.433 3.6 0 2.14-1.663 3.6-3.433 3.6z"></path></g><g id="nlI0H"><path fill="#4285f4" d="M14.152 22.29V11.234H9.77v10.37h-3.42V11.234H2V8.04h15.572v14.25z"></path></g></svg>
                    </div>
                    <h1 class="text-[#202124] dark:text-gray-100 text-2xl font-normal tracking-wide">Sign in</h1>
                    <p class="text-[#202124] dark:text-gray-300 mt-2 text-base">to continue to XpertVA Mail</p>
                </div>

                <div class="px-2">
                    <form id="native-login-form" onsubmit="event.preventDefault(); submitWebmailConfig();" class="space-y-6">
                        <div class="space-y-6">
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email Address</label>
                                <input type="email" name="email" id="email" value="developer@xpertva.com" required 
                                    class="block w-full px-4 py-3 bg-transparent border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#1a73e8] focus:border-[#1a73e8]" 
                                    placeholder="developer@xpertva.com">
                            </div>
                            
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Password</label>
                                <input type="password" name="password" id="password" value="Dev@2026#" required 
                                    class="block w-full px-4 py-3 bg-transparent border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#1a73e8] focus:border-[#1a73e8]" 
                                    placeholder="Enter your password">
                            </div>
                        </div>

                        <div class="pt-2">
                            <p class="text-sm text-[#1a73e8] hover:text-[#174ea6] font-medium cursor-pointer mb-10 w-max">Forgot password?</p>
                            
                            <div id="errorMessage" class="text-red-600 text-sm mb-4 items-start bg-red-50 p-3 rounded hidden">
                                <i class="fa-solid fa-circle-exclamation mt-0.5 mr-2"></i> <span id="errorText"></span>
                            </div>
                            
                            <div id="successMessage" class="text-green-600 text-sm mb-4 items-start bg-green-50 p-3 rounded hidden">
                                <i class="fa-solid fa-circle-check mt-0.5 mr-2"></i> <span id="successText"></span>
                            </div>
                            
                            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mt-2 gap-4">
                                <p class="text-sm text-[#1a73e8] hover:text-[#174ea6] font-medium cursor-pointer">Create account</p>
                                <button type="submit" id="submitBtn" class="inline-flex justify-center items-center py-2 px-6 border border-transparent text-sm font-medium rounded-md text-white bg-[#1a73e8] hover:bg-[#1b66c9] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#1a73e8] disabled:opacity-50 transition-colors">
                                    <svg id="submitSpinner" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white hidden" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                    <span id="submitText">Next</span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script>
            async function submitWebmailConfig() {
                const btn = document.getElementById('submitBtn');
                const spinner = document.getElementById('submitSpinner');
                const text = document.getElementById('submitText');
                const errBox = document.getElementById('errorMessage');
                const errText = document.getElementById('errorText');
                const succBox = document.getElementById('successMessage');
                const succText = document.getElementById('successText');
                const email = document.getElementById('email').value;
                const password = document.getElementById('password').value;

                btn.disabled = true;
                spinner.classList.remove('hidden');
                text.innerText = 'Signing in...';
                errBox.classList.add('hidden');
                errBox.classList.remove('flex');
                succBox.classList.add('hidden');
                succBox.classList.remove('flex');

                try {
                    const response = await fetch('{{ route('webmail.save-config') }}', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') },
                        body: JSON.stringify({ email, password })
                    });
                    const data = await response.json();
                    if (data.success) { 
                        succText.innerText = 'Connection Successful! Loading Inbox...';
                        succBox.classList.remove('hidden');
                        succBox.classList.add('flex');
                        setTimeout(() => window.location.reload(), 1500);
                    } else { 
                        errText.innerText = data.message || 'Failed to connect. Please check credentials.'; 
                        errBox.classList.remove('hidden');
                        errBox.classList.add('flex');
                        btn.disabled = false;
                        spinner.classList.add('hidden');
                        text.innerText = 'Next';
                    }
                } catch (error) { 
                    errText.innerText = 'A network error occurred: ' + error.message; 
                    errBox.classList.remove('hidden');
                    errBox.classList.add('flex');
                    btn.disabled = false;
                    spinner.classList.add('hidden');
                    text.innerText = 'Next';
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
                            <i class="fa-solid fa-reply cursor-pointer hover:text-slate-700"></i>
                            <i class="fa-solid fa-ellipsis-vertical cursor-pointer hover:text-slate-700"></i>
                        </div>
                    </div>
                    <!-- Email Body -->
                    <iframe id="viewBodyFrame" class="w-full border-none ml-14" style="min-height: 400px;" sandbox="allow-same-origin"></iframe>
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
                        <div class="flex-1 px-4 py-2">
                            <textarea id="composeBody" placeholder="" required class="w-full h-full resize-none border-none bg-transparent focus:ring-0 text-[0.875rem] text-[#202124] p-0 focus:outline-none"></textarea>
                        </div>
                        
                        <!-- Error Message -->
                        <div id="composeErrorBox" class="hidden mx-2 mb-2 p-2 bg-red-100 text-red-700 text-xs rounded"></div>
                        
                        <!-- Footer -->
                        <div class="p-3 border-t border-[#f2f2f4] flex items-center justify-between bg-white rounded-b-xl">
                            <div class="flex items-center">
                                <button type="submit" id="btnSendMail" class="bg-[#0b57d0] hover:bg-[#0842a0] disabled:opacity-50 text-white shadow-sm rounded-full px-6 py-2 font-medium text-sm transition-colors flex items-center">
                                    <svg id="composeSpinner" class="hidden animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                    <span id="composeBtnText">Send</span>
                                </button>
                                <div class="w-px h-6 bg-slate-200 mx-4"></div>
                                <i class="fa-solid fa-font text-slate-500 hover:text-slate-700 mr-4 cursor-pointer"></i>
                                <i class="fa-solid fa-paperclip text-slate-500 hover:text-slate-700 mr-4 cursor-pointer"></i>
                                <i class="fa-solid fa-link text-slate-500 hover:text-slate-700 mr-4 cursor-pointer"></i>
                            </div>
                            <button type="button" onclick="closeComposeModal()" class="text-slate-500 hover:text-slate-700 p-2"><i class="fa-solid fa-trash"></i></button>
                        </div>
                    </form>
                </div>
            </div>

        </div>

        <script>
            let currentFolder = 'INBOX';
            let activeEmails = [];
            let isLoading = false;
            let selectedEmails = new Set();
            let starredEmails = new Set();

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
                    const fetchUrl = `{{ route('webmail.fetch') }}?folder=${encodeURIComponent(currentFolder)}`;
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

            function openEmail(index) {
                const mail = activeEmails[index];
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

                mail.flags.seen = true; // Mark as seen locally
            }

            function closeEmail() {
                document.getElementById('emailReadingPane').classList.add('hidden');
                document.getElementById('emailList').classList.remove('hidden');
                // Re-render list to reflect any "seen" changes if applicable
                renderList();
            }

            async function sendMail() {
                const btn = document.getElementById('btnSendMail');
                const spinner = document.getElementById('composeSpinner');
                const btnText = document.getElementById('composeBtnText');
                const errorBox = document.getElementById('composeErrorBox');
                
                const to = document.getElementById('composeTo').value;
                const subject = document.getElementById('composeSubject').value;
                const body = document.getElementById('composeBody').value;

                btn.disabled = true;
                spinner.classList.remove('hidden');
                btnText.innerText = 'Sending...';
                errorBox.classList.add('hidden');

                try {
                    const response = await fetch('{{ route('webmail.send') }}', {
                        method: 'POST',
                        headers: { 
                            'Content-Type': 'application/json', 
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') 
                        },
                        body: JSON.stringify({ to, subject, body })
                    });
                    const data = await response.json();
                    
                    if (data.success) {
                        document.getElementById('composeTo').value = '';
                        document.getElementById('composeSubject').value = '';
                        document.getElementById('composeBody').value = '';
                        closeComposeModal();
                        
                        // Always refresh if on Sent or Inbox
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
