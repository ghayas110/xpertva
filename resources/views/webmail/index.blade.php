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
                    <button onclick="openComposeFresh()" class="bg-[#c2e7ff] hover:bg-[#b3dcf6] text-[#001d35] shadow-[0_1px_2px_0_rgba(60,64,67,0.3),0_1px_3px_1px_rgba(60,64,67,0.15)] rounded-2xl px-5 py-4 font-medium flex items-center transition-all">
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
                        <div class="text-xs text-slate-500 flex items-center space-x-2">
                            <span id="viewDate" class="mr-2"></span>
                            <button type="button" onclick="openReplyModal()" title="Reply" class="hover:bg-slate-100 p-1.5 rounded-full transition-colors">
                                <i class="fa-solid fa-reply"></i>
                            </button>
                            <button type="button" onclick="openReplyAllModal()" title="Reply all" class="hover:bg-slate-100 p-1.5 rounded-full transition-colors">
                                <i class="fa-solid fa-reply-all"></i>
                            </button>
                            <button type="button" onclick="openForwardModal()" title="Forward" class="hover:bg-slate-100 p-1.5 rounded-full transition-colors">
                                <i class="fa-solid fa-share"></i>
                            </button>
                        </div>
                    </div>
                    <!-- Email Body -->
                    <iframe id="viewBodyFrame" class="w-full border-none ml-14" style="min-height: 400px;" sandbox="allow-same-origin allow-popups allow-popups-to-escape-sandbox allow-downloads"></iframe>
                </div>
            </div>
            
            <!-- COMPOSE MODAL -->
            <div id="composeModal" class="hidden fixed bottom-0 right-24 w-[560px] h-[600px] bg-white rounded-t-[8px] shadow-[0_8px_10px_1px_rgba(0,0,0,0.14),0_3px_14px_2px_rgba(0,0,0,0.12),0_5px_5px_-3px_rgba(0,0,0,0.2)] flex flex-col overflow-hidden z-50 transform origin-bottom">
                <!-- Header -->
                <div class="bg-[#f2f6fc] text-[#041e49] px-4 py-2 flex justify-between items-center cursor-pointer rounded-t-[8px]">
                    <span id="composeTitle" class="font-medium text-sm">New Message</span>
                    <div class="flex space-x-3 text-slate-500">
                        <button class="hover:bg-slate-200 px-1 rounded transition-colors"><i class="fa-solid fa-minus"></i></button>
                        <button class="hover:bg-slate-200 px-1 rounded transition-colors" style="font-size: 11px;"><i class="fa-solid fa-up-right-and-down-left-from-center"></i></button>
                        <button onclick="closeComposeModal()" class="hover:bg-slate-200 px-1 rounded transition-colors"><i class="fa-solid fa-xmark"></i></button>
                    </div>
                </div>
                <!-- Body -->
                <div class="flex-1 flex flex-col pt-0 overflow-hidden relative border-l border-r border-[#dadce0]">
                    <form id="composeForm" onsubmit="event.preventDefault(); sendMail();" class="flex flex-col h-full bg-white">
                        <!-- To row (chip input) -->
                        <div class="border-b border-[#f2f2f4] flex items-center gap-2 px-4 min-h-[40px] py-1.5">
                            <span class="text-[0.8rem] text-slate-500 shrink-0">To</span>
                            <div id="composeToChips" data-chip-input class="flex-1 flex flex-wrap items-center gap-1 cursor-text" onclick="this.querySelector('input').focus()">
                                <input type="text" data-chip-entry placeholder="" class="flex-1 min-w-[120px] py-1 bg-transparent border-none focus:ring-0 text-[0.875rem] text-[#202124] placeholder-slate-500 focus:outline-none">
                            </div>
                            <div class="flex items-center gap-2 text-xs text-slate-500 shrink-0">
                                <button type="button" onclick="toggleCcRow()" class="hover:text-[#1a73e8] px-1">Cc</button>
                                <button type="button" onclick="toggleBccRow()" class="hover:text-[#1a73e8] px-1">Bcc</button>
                            </div>
                        </div>
                        <!-- Cc row (hidden by default) -->
                        <div id="composeCcRow" class="hidden border-b border-[#f2f2f4] flex items-center gap-2 px-4 min-h-[40px] py-1.5">
                            <span class="text-[0.8rem] text-slate-500 shrink-0">Cc</span>
                            <div id="composeCcChips" data-chip-input class="flex-1 flex flex-wrap items-center gap-1 cursor-text" onclick="this.querySelector('input').focus()">
                                <input type="text" data-chip-entry placeholder="" class="flex-1 min-w-[120px] py-1 bg-transparent border-none focus:ring-0 text-[0.875rem] text-[#202124] placeholder-slate-500 focus:outline-none">
                            </div>
                        </div>
                        <!-- Bcc row (hidden by default) -->
                        <div id="composeBccRow" class="hidden border-b border-[#f2f2f4] flex items-center gap-2 px-4 min-h-[40px] py-1.5">
                            <span class="text-[0.8rem] text-slate-500 shrink-0">Bcc</span>
                            <div id="composeBccChips" data-chip-input class="flex-1 flex flex-wrap items-center gap-1 cursor-text" onclick="this.querySelector('input').focus()">
                                <input type="text" data-chip-entry placeholder="" class="flex-1 min-w-[120px] py-1 bg-transparent border-none focus:ring-0 text-[0.875rem] text-[#202124] placeholder-slate-500 focus:outline-none">
                            </div>
                        </div>
                        <div class="border-b border-[#f2f2f4] flex flex-col justify-end px-4 min-h-[40px]">
                            <input type="text" id="composeSubject" placeholder="Subject" required class="w-full py-1 bg-transparent border-none focus:ring-0 text-[0.875rem] text-[#202124] placeholder-slate-500 focus:outline-none">
                        </div>

                        <!-- Formatting toolbar -->
                        <div class="border-b border-[#f2f2f4] px-2 py-1 flex flex-wrap items-center gap-0.5 bg-[#fafafa] text-slate-600">
                            <select onchange="composeExec('fontSize', this.value); this.value='';" title="Text size" class="text-xs bg-transparent border-none focus:ring-0 cursor-pointer px-1 py-1 hover:bg-slate-200 rounded">
                                <option value="">Size</option>
                                <option value="1">Small</option>
                                <option value="3">Normal</option>
                                <option value="5">Large</option>
                                <option value="7">Huge</option>
                            </select>
                            <span class="w-px h-5 bg-slate-300 mx-1"></span>
                            <button type="button" onclick="composeExec('bold')"     title="Bold (Ctrl+B)"      class="w-7 h-7 hover:bg-slate-200 rounded"><i class="fa-solid fa-bold text-xs"></i></button>
                            <button type="button" onclick="composeExec('italic')"   title="Italic (Ctrl+I)"    class="w-7 h-7 hover:bg-slate-200 rounded"><i class="fa-solid fa-italic text-xs"></i></button>
                            <button type="button" onclick="composeExec('underline')" title="Underline (Ctrl+U)" class="w-7 h-7 hover:bg-slate-200 rounded"><i class="fa-solid fa-underline text-xs"></i></button>
                            <button type="button" onclick="composeExec('strikeThrough')" title="Strikethrough" class="w-7 h-7 hover:bg-slate-200 rounded"><i class="fa-solid fa-strikethrough text-xs"></i></button>
                            <span class="w-px h-5 bg-slate-300 mx-1"></span>
                            <label title="Text color" class="w-7 h-7 hover:bg-slate-200 rounded flex items-center justify-center cursor-pointer relative">
                                <i class="fa-solid fa-palette text-xs"></i>
                                <input type="color" oninput="composeExec('foreColor', this.value)" class="absolute inset-0 opacity-0 cursor-pointer">
                            </label>
                            <label title="Background color" class="w-7 h-7 hover:bg-slate-200 rounded flex items-center justify-center cursor-pointer relative">
                                <i class="fa-solid fa-highlighter text-xs"></i>
                                <input type="color" oninput="composeExec('hiliteColor', this.value); composeExec('backColor', this.value);" class="absolute inset-0 opacity-0 cursor-pointer">
                            </label>
                            <span class="w-px h-5 bg-slate-300 mx-1"></span>
                            <button type="button" onclick="composeExec('justifyLeft')"    title="Align left"    class="w-7 h-7 hover:bg-slate-200 rounded"><i class="fa-solid fa-align-left text-xs"></i></button>
                            <button type="button" onclick="composeExec('justifyCenter')"  title="Align center"  class="w-7 h-7 hover:bg-slate-200 rounded"><i class="fa-solid fa-align-center text-xs"></i></button>
                            <button type="button" onclick="composeExec('justifyRight')"   title="Align right"   class="w-7 h-7 hover:bg-slate-200 rounded"><i class="fa-solid fa-align-right text-xs"></i></button>
                            <button type="button" onclick="composeExec('justifyFull')"    title="Justify"       class="w-7 h-7 hover:bg-slate-200 rounded"><i class="fa-solid fa-align-justify text-xs"></i></button>
                            <span class="w-px h-5 bg-slate-300 mx-1"></span>
                            <button type="button" onclick="composeExec('insertUnorderedList')" title="Bullet list"  class="w-7 h-7 hover:bg-slate-200 rounded"><i class="fa-solid fa-list-ul text-xs"></i></button>
                            <button type="button" onclick="composeExec('insertOrderedList')"   title="Numbered list" class="w-7 h-7 hover:bg-slate-200 rounded"><i class="fa-solid fa-list-ol text-xs"></i></button>
                            <button type="button" onclick="composeExec('outdent')" title="Decrease indent" class="w-7 h-7 hover:bg-slate-200 rounded"><i class="fa-solid fa-outdent text-xs"></i></button>
                            <button type="button" onclick="composeExec('indent')"  title="Increase indent" class="w-7 h-7 hover:bg-slate-200 rounded"><i class="fa-solid fa-indent text-xs"></i></button>
                            <span class="w-px h-5 bg-slate-300 mx-1"></span>
                            <button type="button" onclick="composeExec('formatBlock','blockquote')" title="Quote" class="w-7 h-7 hover:bg-slate-200 rounded"><i class="fa-solid fa-quote-right text-xs"></i></button>
                            <button type="button" onclick="composeExec('removeFormat')" title="Clear formatting" class="w-7 h-7 hover:bg-slate-200 rounded"><i class="fa-solid fa-text-slash text-xs"></i></button>
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
                                <button type="button" onclick="document.getElementById('composeFileInput').click()" title="Attach file" class="px-2 py-1 hover:bg-slate-100 rounded text-slate-600 transition-colors">
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

            /* Chip input styles (Gmail-like) */
            .recipient-chip {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                background: #e8f0fe;
                color: #1f1f1f;
                border: 1px solid transparent;
                border-radius: 9999px;
                padding: 2px 4px 2px 10px;
                font-size: 12px;
                line-height: 1.4;
                max-width: 100%;
            }
            .recipient-chip.invalid {
                background: #fce8e6;
                color: #c5221f;
                border-color: #f4c7c3;
            }
            .recipient-chip .chip-text {
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
                max-width: 220px;
            }
            .recipient-chip .chip-remove {
                width: 18px;
                height: 18px;
                border-radius: 9999px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                color: #5f6368;
            }
            .recipient-chip .chip-remove:hover { background: rgba(0,0,0,0.08); color: #202124; }
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

            /* ─── Recipient chip inputs (Gmail-style) ─────────────── */
            const EMAIL_RE = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            function extractEmail(raw) {
                if (!raw) return '';
                let s = String(raw).trim().replace(/[,;]+$/, '');
                const m = s.match(/<([^>]+)>/);
                if (m) s = m[1];
                return s.trim();
            }

            function commitChipFromInput(container, opts = {}) {
                const input = container.querySelector('[data-chip-entry]');
                const text  = (input.value || '').trim().replace(/[,;]+$/, '');
                if (!text) return false;
                addChip(container, text);
                input.value = '';
                return true;
            }

            function addChip(container, raw) {
                const email = extractEmail(raw);
                if (!email) return;
                // Avoid duplicates
                const existing = Array.from(container.querySelectorAll('.recipient-chip'))
                    .map(c => c.dataset.email.toLowerCase());
                if (existing.includes(email.toLowerCase())) return;

                const chip = document.createElement('span');
                chip.className = 'recipient-chip' + (EMAIL_RE.test(email) ? '' : ' invalid');
                chip.dataset.email = email;
                chip.innerHTML =
                    '<span class="chip-text" title="' + email.replace(/"/g, '&quot;') + '">' + escapeHtml(email) + '</span>' +
                    '<span class="chip-remove" title="Remove">&times;</span>';
                chip.querySelector('.chip-remove').addEventListener('click', (e) => {
                    e.stopPropagation();
                    chip.remove();
                });
                const input = container.querySelector('[data-chip-entry]');
                container.insertBefore(chip, input);
            }

            function getChips(container) {
                return Array.from(container.querySelectorAll('.recipient-chip')).map(c => c.dataset.email);
            }

            function clearChips(container) {
                container.querySelectorAll('.recipient-chip').forEach(c => c.remove());
                const input = container.querySelector('[data-chip-entry]');
                if (input) input.value = '';
            }

            function attachChipBehavior(container) {
                const input = container.querySelector('[data-chip-entry]');
                if (!input || input.dataset.chipBound) return;
                input.dataset.chipBound = '1';

                input.addEventListener('keydown', (e) => {
                    // Enter / Tab / comma / semicolon → commit chip; never submit the form
                    if (e.key === 'Enter' || e.key === 'Tab' || e.key === ',' || e.key === ';') {
                        if (input.value.trim()) {
                            e.preventDefault();
                            commitChipFromInput(container);
                        } else if (e.key === 'Enter') {
                            // Prevent accidental form submit when field is empty
                            e.preventDefault();
                        }
                    } else if (e.key === 'Backspace' && input.value === '') {
                        // Remove the last chip
                        const chips = container.querySelectorAll('.recipient-chip');
                        if (chips.length) chips[chips.length - 1].remove();
                    }
                });

                // Paste → split on commas / semicolons / whitespace, create a chip per token
                input.addEventListener('paste', (e) => {
                    const data = (e.clipboardData || window.clipboardData).getData('text');
                    if (data && /[,;\s]/.test(data)) {
                        e.preventDefault();
                        data.split(/[\s,;]+/).forEach(t => { if (t) addChip(container, t); });
                    }
                });

                // Blur → commit whatever's typed
                input.addEventListener('blur', () => { commitChipFromInput(container); });
            }

            // Bind on page load
            document.addEventListener('DOMContentLoaded', () => {
                document.querySelectorAll('[data-chip-input]').forEach(attachChipBehavior);
            });

            /* ─── Quote the email being replied to / forwarded ─── */
            function buildQuotedBody(mail) {
                const when    = escapeHtml(mail.date || '');
                const fromStr = escapeHtml((mail.from_name || '') + ' <' + (mail.from || '') + '>');
                const inner   = mail.body || '';
                return (
                    '<br><br>' +
                    '<div style="border-left:2px solid #ccc;padding-left:10px;color:#555;margin-top:8px">' +
                    '<div style="font-size:12px;color:#888;margin-bottom:6px">On ' + when + ', ' + fromStr + ' wrote:</div>' +
                    inner +
                    '</div>'
                );
            }

            /* Resolve the current account email (so we exclude ourselves from Reply All) */
            const CURRENT_ACCOUNT_EMAIL = @json(optional(auth()->user()->emailAccount)->email ?? '');

            function splitAddresses(raw) {
                if (!raw) return [];
                return raw.split(/[,;]+/).map(s => s.trim()).filter(Boolean);
            }

            function setComposeTitle(t) {
                const el = document.getElementById('composeTitle');
                if (el) el.innerText = t;
            }

            function prepareComposeReset() {
                clearChips(document.getElementById('composeToChips'));
                clearChips(document.getElementById('composeCcChips'));
                clearChips(document.getElementById('composeBccChips'));
                document.getElementById('composeSubject').value = '';
                document.getElementById('composeBody').innerHTML = '';
                document.getElementById('composeCcRow').classList.add('hidden');
                document.getElementById('composeBccRow').classList.add('hidden');
                if (typeof resetComposeAttachments === 'function') resetComposeAttachments();
            }

            function openComposeFresh() {
                prepareComposeReset();
                setComposeTitle('New Message');
                openComposeModal();
                setTimeout(() => document.querySelector('#composeToChips [data-chip-entry]').focus(), 50);
            }

            function openReplyModal() {
                const mail = currentOpenMail;
                if (!mail) { alert('Open an email first to reply.'); return; }
                prepareComposeReset();
                setComposeTitle('Reply');

                const replyTo = mail.reply_to || mail.from;
                const subject = mail.subject && mail.subject.match(/^Re:/i) ? mail.subject : 'Re: ' + (mail.subject || '');
                if (replyTo) addChip(document.getElementById('composeToChips'), replyTo);
                document.getElementById('composeSubject').value = subject;
                document.getElementById('composeBody').innerHTML = buildQuotedBody(mail);

                openComposeModal();
                setTimeout(() => {
                    const b = document.getElementById('composeBody');
                    b.focus();
                    // Put cursor at the very top so user types above the quote
                    const range = document.createRange();
                    range.setStart(b, 0);
                    range.collapse(true);
                    const sel = window.getSelection();
                    sel.removeAllRanges();
                    sel.addRange(range);
                }, 50);
            }

            function openReplyAllModal() {
                const mail = currentOpenMail;
                if (!mail) { alert('Open an email first to reply.'); return; }
                prepareComposeReset();
                setComposeTitle('Reply all');

                const me = (CURRENT_ACCOUNT_EMAIL || '').toLowerCase();
                const primary = (mail.reply_to || mail.from || '').trim();

                // Collect every original recipient (To + Cc) minus ourselves and the primary reply target
                const allRecips = [
                    ...splitAddresses(mail.to_list || mail.to || ''),
                    ...splitAddresses(mail.cc_list || mail.cc || ''),
                ];
                const ccList = [];
                const seen = new Set([me, primary.toLowerCase()]);
                allRecips.forEach(addr => {
                    const clean = addr.replace(/.*<|>.*/g, '').trim().toLowerCase();
                    if (clean && !seen.has(clean)) {
                        seen.add(clean);
                        ccList.push(addr);
                    }
                });

                const subject = mail.subject && mail.subject.match(/^Re:/i) ? mail.subject : 'Re: ' + (mail.subject || '');
                if (primary) addChip(document.getElementById('composeToChips'), primary);
                document.getElementById('composeSubject').value = subject;
                document.getElementById('composeBody').innerHTML = buildQuotedBody(mail);

                if (ccList.length) {
                    const ccBox = document.getElementById('composeCcChips');
                    ccList.forEach(addr => addChip(ccBox, addr));
                    document.getElementById('composeCcRow').classList.remove('hidden');
                }

                openComposeModal();
                setTimeout(() => document.getElementById('composeBody').focus(), 50);
            }

            function openForwardModal() {
                const mail = currentOpenMail;
                if (!mail) { alert('Open an email first to forward.'); return; }
                prepareComposeReset();
                setComposeTitle('Forward');

                const subject = mail.subject && mail.subject.match(/^Fwd:/i) ? mail.subject : 'Fwd: ' + (mail.subject || '');
                document.getElementById('composeSubject').value = subject;
                document.getElementById('composeBody').innerHTML = buildQuotedBody(mail);

                openComposeModal();
                setTimeout(() => document.querySelector('#composeToChips [data-chip-entry]').focus(), 50);
            }

            function toggleCcRow()  { document.getElementById('composeCcRow').classList.toggle('hidden'); }
            function toggleBccRow() { document.getElementById('composeBccRow').classList.toggle('hidden'); }

            /* ─── Compose rich-text helpers ─── */
            function composeExec(cmd, value = null) {
                document.getElementById('composeBody').focus();
                try { document.execCommand(cmd, false, value); } catch (e) {}
            }

            function composeBold() { composeExec('bold'); } // back-compat

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

                // Commit any half-typed chips before reading values
                const toBox  = document.getElementById('composeToChips');
                const ccBox  = document.getElementById('composeCcChips');
                const bccBox = document.getElementById('composeBccChips');
                commitChipFromInput(toBox);
                commitChipFromInput(ccBox);
                commitChipFromInput(bccBox);

                const toChips  = getChips(toBox);
                const ccChips  = getChips(ccBox);
                const bccChips = getChips(bccBox);
                const to       = toChips.join(',');
                const cc       = ccChips.join(',');
                const bcc      = bccChips.join(',');
                const subject  = document.getElementById('composeSubject').value.trim();
                const bodyEl   = document.getElementById('composeBody');
                const body     = bodyEl.innerHTML.trim();

                errorBox.classList.add('hidden');

                if (!toChips.length || !subject) {
                    errorBox.innerText = 'Please fill in To and Subject.';
                    errorBox.classList.remove('hidden');
                    return;
                }

                // Check for invalid chips
                const invalidChips = document.querySelectorAll('.recipient-chip.invalid');
                if (invalidChips.length) {
                    errorBox.innerText = 'One or more recipients are invalid email addresses.';
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
                    if (cc)  fd.append('cc',  cc);
                    if (bcc) fd.append('bcc', bcc);
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
                        prepareComposeReset();
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
