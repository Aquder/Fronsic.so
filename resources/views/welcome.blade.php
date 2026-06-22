<!DOCTYPE html>
<html lang="en" class="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forensic AI API - Swagger UI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        darkBg: '#0f172a',
                        cardBg: '#1e293b',
                        primary: '#38bdf8',
                        get: '#3b82f6',
                        post: '#10b981',
                        put: '#f59e0b',
                        delete: '#ef4444'
                    }
                }
            }
        }
    </script>
    <style>
        .method-get {
            border-color: #3b82f6;
            background-color: rgba(59, 130, 246, 0.1);
        }

        .method-get .badge {
            background-color: #3b82f6;
        }

        .method-post {
            border-color: #10b981;
            background-color: rgba(16, 185, 129, 0.1);
        }

        .method-post .badge {
            background-color: #10b981;
        }

        .method-put {
            border-color: #f59e0b;
            background-color: rgba(245, 158, 11, 0.1);
        }

        .method-put .badge {
            background-color: #f59e0b;
        }

        .method-delete {
            border-color: #ef4444;
            background-color: rgba(239, 68, 68, 0.1);
        }

        .method-delete .badge {
            background-color: #ef4444;
        }
    </style>
</head>

<body class="bg-darkBg text-gray-200 font-sans antialiased p-6 min-h-screen">

    <div class="max-w-6xl mx-auto mb-10">
        <div class="flex justify-between items-center border-b border-gray-700 pb-4 mb-6">
            <div>
                <h1 class="text-3xl font-bold text-white tracking-wide">Forensic AI API <span
                        class="text-primary text-lg font-normal">v1.0 (Workspace by Ahmed Quder)</span></h1>
                <p class="text-gray-400 mt-1">Interactive API documentation & testing interface.</p>
            </div>
        </div>

        <div
            class="bg-cardBg p-5 rounded-lg border border-gray-700 shadow-lg flex flex-col md:flex-row gap-4 items-end">
            <div class="flex-1 w-full" style="display: none;">
                <label class="block text-sm text-gray-400 mb-1">Base URL</label>
                <input type="text" id="baseUrl" value="https://fronsicso-production.up.railway.app/"
                    oninput="updateAllUrls()"
                    class="w-full bg-darkBg border border-gray-600 rounded p-2 text-white outline-none focus:border-primary">
            </div>
            <div class="flex-1 w-full">
                <label class="block text-sm text-gray-400 mb-1">Authorization (Bearer Token)</label>
                <div class="relative">
                    <i class="fas fa-lock absolute left-3 top-3 text-gray-500"></i>
                    <input type="text" id="globalToken" placeholder="Enter your token here..."
                        class="w-full bg-darkBg border border-gray-600 rounded p-2 pl-9 text-white outline-none focus:border-primary">
                </div>
            </div>
        </div>
    </div>

    <div id="endpoints-container" class="max-w-6xl mx-auto space-y-4">
    </div>

    <script>
        // 1. Array of Objects - 57 Endpoints (Matched exactly with Postman JSON)
        const endpoints = [
            // --- 1. Authentication ---
            {
                method: 'POST',
                path: 'api/register',
                title: 'User Register',
                group: 'Authentication',
                bodyType: 'json',
                fields: [{
                    name: 'name',
                    type: 'text'
                }, {
                    name: 'email',
                    type: 'email'
                }, {
                    name: 'phone_number',
                    type: 'text'
                }, {
                    name: 'date_of_birth',
                    type: 'date'
                }, {
                    name: 'national_id',
                    type: 'text'
                }, {
                    name: 'password',
                    type: 'password'
                }]
            },
            {
                method: 'POST',
                path: 'api/login',
                title: 'User Login',
                group: 'Authentication',
                bodyType: 'json',
                fields: [{
                    name: 'email',
                    type: 'email'
                }, {
                    name: 'password',
                    type: 'password'
                }]
            },
            {
                method: 'POST',
                path: 'api/logout',
                title: 'Logout',
                group: 'Authentication',
                bodyType: 'json',
                fields: []
            },
            {
                method: 'POST',
                path: 'api/password/forgot',
                title: 'Forgot Password',
                group: 'Authentication',
                bodyType: 'json',
                fields: [{
                    name: 'email',
                    type: 'email'
                }]
            },
            {
                method: 'POST',
                path: 'api/password/verify-code',
                title: 'Verify Code',
                group: 'Authentication',
                bodyType: 'json',
                fields: [{
                    name: 'otp',
                    type: 'number'
                }, {
                    name: 'email',
                    type: 'email'
                }]
            },
            {
                method: 'POST',
                path: 'api/password/reset',
                title: 'Reset Password',
                group: 'Authentication',
                bodyType: 'json',
                fields: [{
                    name: 'email',
                    type: 'email'
                }, {
                    name: 'otp',
                    type: 'number'
                }, {
                    name: 'password',
                    type: 'password'
                }, {
                    name: 'password_confirmation',
                    type: 'password'
                }]
            },

            // --- 2. Doctor Hub ---
            {
                method: 'GET',
                path: 'api/doctor/dashboard',
                title: 'Doctor Dashboard',
                group: 'Doctor Hub',
                hasParams: false
            },
            {
                method: 'GET',
                path: 'api/doctor/dashboard-flutter',
                title: 'Flutter Dashboard',
                group: 'Doctor Hub',
                hasParams: false
            },
            {
                method: 'GET',
                path: 'api/doctor/dashboard-flutter/active-case',
                title: 'Active Cases Flutter',
                group: 'Doctor Hub',
                hasParams: false
            },
            {
                method: 'GET',
                path: 'api/doctor/dashboard-flutter/complete-case',
                title: 'Complete Cases Flutter',
                group: 'Doctor Hub',
                hasParams: false
            },
            {
                method: 'GET',
                path: 'api/doctor/dashboard-flutter/evidence-list',
                title: 'Evidence List Flutter',
                group: 'Doctor Hub',
                hasParams: false
            },

            // --- 3. Use Cases ---
            {
                method: 'GET',
                path: 'api/all-cases',
                title: 'All Cases',
                group: 'Use Cases',
                bodyType: 'json',
                fields: []
            },
            {
                method: 'POST',
                path: 'api/add/use-case',
                title: 'Add Use Case',
                group: 'Use Cases',
                bodyType: 'json',
                fields: [{
                    name: 'name',
                    type: 'text'
                }, {
                    name: 'description',
                    type: 'text'
                }]
            },
            {
                method: 'GET',
                path: 'api/show/use-case/{id}',
                title: 'Show Use Case',
                group: 'Use Cases',
                hasParams: true,
                params: ['id']
            },
            {
                method: 'PUT',
                path: 'api/update/use-case/{id}',
                title: 'Update Use Case',
                group: 'Use Cases',
                hasParams: true,
                params: ['id'],
                bodyType: 'json',
                fields: [{
                    name: 'name',
                    type: 'text'
                }, {
                    name: 'description',
                    type: 'text'
                }]
            },
            {
                method: 'DELETE',
                path: 'api/delete/use-case/{id}',
                title: 'Delete Use Case',
                group: 'Use Cases',
                hasParams: true,
                params: ['id']
            },
            {
                method: 'GET',
                path: 'api/toggle-active/use-case/{id}',
                title: 'Toggle Active Use Case',
                group: 'Use Cases',
                hasParams: true,
                params: ['id']
            },

            // --- 4. Evidence ---
            {
                method: 'POST',
                path: 'api/save-as-evidence',
                title: 'Save As Evidence',
                group: 'Evidence',
                bodyType: 'json',
                fields: [{
                    name: 'name',
                    type: 'text'
                }, {
                    name: 'case_id',
                    type: 'number'
                }, {
                    name: 'data',
                    type: 'text'
                }]
            },
            {
                method: 'PUT',
                path: 'api/update-evidence/{id}/use-case/{usecaseId}',
                title: 'Update Evidence',
                group: 'Evidence',
                hasParams: true,
                params: ['id', 'usecaseId'],
                bodyType: 'json',
                fields: [{
                    name: 'name',
                    type: 'text'
                }]
            },
            {
                method: 'DELETE',
                path: 'api/delete-evidence/{id}/use-case/{usecaseId}',
                title: 'Delete Evidence',
                group: 'Evidence',
                hasParams: true,
                params: ['id', 'usecaseId']
            },

            // --- 5. Feed & Articles ---
            {
                method: 'GET',
                path: 'api/feed',
                title: 'Get All Feeds',
                group: 'Feed & Articles',
                hasParams: false
            },
            {
                method: 'POST',
                path: 'api/add/new-article',
                title: 'Add New Article',
                group: 'Feed & Articles',
                bodyType: 'formdata',
                fields: [{
                    name: 'title',
                    type: 'text'
                }, {
                    name: 'content',
                    type: 'text'
                }, {
                    name: 'image',
                    type: 'file'
                }]
            },
            {
                method: 'POST',
                path: 'api/update-article/{id}',
                title: 'Update Article',
                group: 'Feed & Articles',
                hasParams: true,
                params: ['id'],
                bodyType: 'formdata',
                fields: [{
                    name: 'title',
                    type: 'text'
                }, {
                    name: 'content',
                    type: 'text'
                }, {
                    name: 'image',
                    type: 'file'
                }]
            },
            {
                method: 'DELETE',
                path: 'api/delete-article/{id}',
                title: 'Delete Article',
                group: 'Feed & Articles',
                hasParams: true,
                params: ['id']
            },
            {
                method: 'GET',
                path: 'api/share-article/{id}',
                title: 'Share Article',
                group: 'Feed & Articles',
                hasParams: true,
                params: ['id']
            },
            {
                method: 'POST',
                path: 'api/add-comments-article/{id}',
                title: 'Add Comment (Article)',
                group: 'Feed & Articles',
                hasParams: true,
                params: ['id'],
                bodyType: 'json',
                fields: [{
                    name: 'comment',
                    type: 'text'
                }]
            },
            {
                method: 'POST',
                path: 'api/toggle-like/article/{id}',
                title: 'Toggle Like (Article)',
                group: 'Feed & Articles',
                hasParams: true,
                params: ['id'],
                bodyType: 'json',
                fields: []
            },
            {
                method: 'GET',
                path: 'api/view-article/{id}',
                title: 'View Article',
                group: 'Feed & Articles',
                hasParams: true,
                params: ['id']
            },

            {
                method: 'POST',
                path: 'api/add/new-feed',
                title: 'Add New Feed',
                group: 'Feed & Articles',
                bodyType: 'formdata',
                fields: [{
                    name: 'content',
                    type: 'text'
                }]
            },
            {
                method: 'POST',
                path: 'api/update-feed/{id}',
                title: 'Update Feed',
                group: 'Feed & Articles',
                hasParams: true,
                params: ['id'],
                bodyType: 'formdata',
                fields: [{
                    name: 'content',
                    type: 'text'
                }]
            },
            {
                method: 'DELETE',
                path: 'api/delete-feed/{id}',
                title: 'Delete Feed',
                group: 'Feed & Articles',
                hasParams: true,
                params: ['id']
            },
            {
                method: 'GET',
                path: 'api/share-feed/{id}',
                title: 'Share Feed',
                group: 'Feed & Articles',
                hasParams: true,
                params: ['id']
            },
            {
                method: 'POST',
                path: 'api/toggle-like/feed/{id}',
                title: 'Toggle Like (Feed)',
                group: 'Feed & Articles',
                hasParams: true,
                params: ['id'],
                bodyType: 'json',
                fields: []
            },
            {
                method: 'GET',
                path: 'api/view-feeds/{id}',
                title: 'View Feed',
                group: 'Feed & Articles',
                hasParams: true,
                params: ['id']
            },
            {
                method: 'POST',
                path: 'api/add-comments-feed/{id}',
                title: 'Add Comment (Feed)',
                group: 'Feed & Articles',
                hasParams: true,
                params: ['id'],
                bodyType: 'json',
                fields: [{
                    name: 'comment',
                    type: 'text'
                }]
            },
            {
                method: 'PUT',
                path: 'api/update-comment/{id}',
                title: 'Update Comment',
                group: 'Feed & Articles',
                hasParams: true,
                params: ['id'],
                bodyType: 'json',
                fields: [{
                    name: 'comment',
                    type: 'text'
                }]
            },
            {
                method: 'DELETE',
                path: 'api/delete-comment/{id}',
                title: 'Delete Comment',
                group: 'Feed & Articles',
                hasParams: true,
                params: ['id']
            },

            // --- 6. Chat ---
            {
                method: 'GET',
                path: 'api/conversations/{id}/messages',
                title: 'Conversation Messages',
                group: 'Chat System',
                hasParams: true,
                params: ['id']
            },
            {
                method: 'GET',
                path: 'api/chat',
                title: 'Get Chats',
                group: 'Chat System',
                hasParams: false
            },
            {
                method: 'POST',
                path: 'api/chat/send',
                title: 'Send Message',
                group: 'Chat System',
                bodyType: 'json',
                fields: [{
                    name: 'query',
                    type: 'text'
                }, {
                    name: 'conversation_id',
                    type: 'number'
                }]
            },

            // --- 7. AI Models ---
            {
                method: 'POST',
                path: 'api/dna-analysis',
                title: 'DNA Analysis',
                group: 'AI Forensic Models',
                isDnaAnalysis: true
            },
            {
                method: 'POST',
                path: 'api/deep-fake',
                title: 'Deep Fake Analyze',
                group: 'AI Forensic Models',
                bodyType: 'formdata',
                fields: [{
                    name: 'image',
                    type: 'file'
                }]
            },
            {
                method: 'POST',
                path: 'api/face-recognation',
                title: 'Face Recognition',
                group: 'AI Forensic Models',
                bodyType: 'json',
                fields: [{
                    name: 'image',
                    type: 'file'
                }]
            },
            {
                method: 'POST',
                path: 'api/face-reconstructs',
                title: 'Face Reconstructs',
                group: 'AI Forensic Models',
                bodyType: 'formdata',
                fields: [{
                    name: 'image',
                    type: 'file'
                }]
            },

            // --- 8. user setting ---
            {
                method: 'GET',
                path: 'api/setting',
                title: 'User Settings',
                group: 'User Setting',
                hasParams: false
            },
            {
                method: 'PUT',
                path: 'api/save-change',
                title: 'Save Profile Changes',
                group: 'User Setting',
                bodyType: 'json',
                fields: [{
                    name: 'first_name',
                    type: 'text'
                }, {
                    name: 'last_name',
                    type: 'text'
                }, {
                    name: 'email',
                    type: 'email'
                }, {
                    name: 'phone_number',
                    type: 'text'
                }, {
                    name: 'date_of_birth',
                    type: 'date'
                }, {
                    name: 'national_id',
                    type: 'text'
                }, {
                    name: 'image',
                    type: 'file'
                }]
            },
            {
                method: 'POST',
                path: 'api/change-password',
                title: 'Change Password',
                group: 'User Setting',
                bodyType: 'json',
                fields: [{
                    name: 'current_password',
                    type: 'password'
                }, {
                    name: 'new_password',
                    type: 'password'
                }, {
                    name: 'new_password_confirmation',
                    type: 'password'
                }]
            },

            // --- 9. Admin Panel ---
            {
                method: 'GET',
                path: 'api/admin/dashboard',
                title: 'Admin Dashboard Data',
                group: 'Admin Panel',
                hasParams: false
            },
            {
                method: 'GET',
                path: 'api/admin/doctors',
                title: 'Get All Doctors',
                group: 'Admin Panel',
                hasParams: false
            },
            {
                method: 'GET',
                path: 'api/admin/profile/doctors/{id}',
                title: 'Doctor Profile Data',
                group: 'Admin Panel',
                hasParams: true,
                params: ['id']
            },
            {
                method: 'GET',
                path: 'api/admin/cases',
                title: 'Cases Audit',
                group: 'Admin Panel',
                hasParams: false
            },
            {
                method: 'GET',
                path: 'api/admin/community',
                title: 'Community Management',
                group: 'Admin Panel',
                hasParams: false
            },
            {
                method: 'GET',
                path: 'api/admin/chat-mangement',
                title: 'Chat Management',
                group: 'Admin Panel',
                hasParams: false
            },
            {
                method: 'GET',
                path: 'api/admin/toggle/active/{id}',
                title: 'Toggle User Active/Block',
                group: 'Admin Panel',
                hasParams: true,
                params: ['id']
            },
            {
                method: 'GET',
                path: 'api/admin/system-log',
                title: 'System Logs Hub',
                group: 'Admin Panel',
                hasParams: false
            },
            {
                method: 'GET',
                path: 'api/admin/get-global-report-data',
                title: 'Export Global Report Data',
                group: 'Admin Panel',
                hasParams: false
            },
            {
                method: 'GET',
                path: 'api/admin/doctors/assign/admin/{id}',
                title: 'Assign Admin to Doctor',
                group: 'Admin Panel',
                hasParams: true,
                params: ['id']
            }
        ];

        endpoints.forEach(ep => {
            // نبحث عن كلمة api/ ونقص كل ما قبلها (لحذف أي دومين ملتصق بالمسار)
            const apiIndex = ep.path.indexOf('api/');
            if (apiIndex !== -1) {
                ep.path = '/' + ep.path.substring(apiIndex);
            } else {
                // في حال عدم وجود كلمة api، نتأكد فقط أنه يبدأ بـ /
                if (!ep.path.startsWith('/')) {
                    ep.path = '/' + ep.path;
                }
            }
        });


        function renderUI() {
            const container = document.getElementById('endpoints-container');
            container.innerHTML = '';
            let currentGroup = '';

            // 🌟 استخراج الرابط الأساسي وتنظيفه لضمان دمج سليم
            const baseUrlInput = document.getElementById('baseUrl');
            let baseUrl = baseUrlInput ? baseUrlInput.value.trim().replace(/\/$/, "") : "";

            endpoints.forEach((ep, index) => {
                // 🌟 تطبيق التعديل الذكي لضبط مسار الـ Endpoint
                const cleanPath = ep.path.startsWith('/') ? ep.path : '/' + ep.path;
                const initialFullUrl = baseUrl + cleanPath;



                if (ep.group !== currentGroup) {
                    currentGroup = ep.group;
                    container.innerHTML +=
                        `<h2 class="text-xl font-bold text-white mt-8 mb-4 border-b border-gray-700 pb-2">${currentGroup}</h2>`;
                }

                const methodClass = `method-${ep.method.toLowerCase()}`;

                let html = `
                    <div class="border rounded-lg mb-3 ${methodClass}">
                        <div class="p-3 flex items-center justify-between cursor-pointer" onclick="toggleDetails(${index})">
                            <div class="flex items-center gap-4">
                                <span class="badge text-white font-bold px-3 py-1 rounded w-20 text-center">${ep.method}</span>
                                <span class="font-mono font-bold text-gray-200" id="endpoint-url-${index}">${ep.name}</span>
                                <span class="text-gray-400 text-sm hidden md:inline-block">- ${ep.title}</span>
                            </div>
                            <i class="fas fa-chevron-down text-gray-400 transition-transform duration-200" id="icon-${index}"></i>
                        </div>

                        <div id="details-${index}" class="hidden bg-cardBg border-t border-gray-700 p-5 rounded-b-lg">

                            <div class="mb-5 bg-darkBg border border-gray-700 rounded p-3">
                                <label class="block text-xs font-semibold text-gray-400 mb-1">Request URL</label>
                                <div id="url-text-${index}" class="text-sm font-mono text-primary break-all">${initialFullUrl}</div>
                            </div>

                            <h3 class="text-sm font-semibold text-gray-300 mb-4 border-b border-gray-700 pb-2">Parameters & Request Body</h3>
                `;

                // Handle Path Parameters
                if (ep.hasParams && ep.params) {
                    html += `<div class="mb-4">`;
                    ep.params.forEach(param => {
                        html += `
                            <div class="flex items-center gap-4 mb-2">
                                <label class="w-24 font-mono text-sm text-primary">{${param}}}</label>
                                <input type="text" id="param-${index}-${param}" onkeyup="updateLiveUrl(${index})" placeholder="Value for {${param}}" class="flex-1 bg-darkBg border border-gray-600 rounded p-1.5 text-white outline-none focus:border-primary">
                            </div>
                        `;
                    });
                    html += `</div>`;
                }

                // Handle DNA Custom Tabs
                if (ep.isDnaAnalysis) {
                    html += `
                        <div class="mb-4 bg-darkBg border border-gray-700 rounded p-4">
                            <div class="flex gap-2 border-b border-gray-700 mb-4 pb-2">
                                <button onclick="switchDnaTab(${index}, 'sequence')" id="tab-btn-seq-${index}" class="px-4 py-1 text-sm bg-primary text-darkBg rounded font-bold transition">Enter Text</button>
                                <button onclick="switchDnaTab(${index}, 'file')" id="tab-btn-file-${index}" class="px-4 py-1 text-sm text-gray-400 hover:text-white transition">Upload File</button>
                                <input type="hidden" id="dna-active-tab-${index}" value="sequence">
                            </div>

                            <div id="tab-content-seq-${index}" class="block">
                                <label class="block text-sm text-gray-400 mb-1">Sequence Data Input:</label>
                                <textarea name="sequance" id="dna-seq-${index}" rows="4" class="w-full bg-cardBg border border-gray-600 rounded p-2 text-white outline-none focus:border-primary" placeholder="Paste DNA sequences or allele values here..."></textarea>
                            </div>

                            <div id="tab-content-file-${index}" class="hidden">
                                <label class="block text-sm text-gray-400 mb-1">DNA File Upload:</label>
                                <input type="file" name="file" id="dna-file-${index}" class="w-full text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-primary file:text-darkBg hover:file:bg-blue-400">
                            </div>
                        </div>
                    `;
                }
                // Handle Standard Form Fields
                else if (ep.method !== 'GET' && ep.fields && ep.fields.length > 0) {
                    html += `<div class="mb-4 bg-darkBg border border-gray-700 rounded p-4 space-y-3">`;
                    ep.fields.forEach(field => {
                        html += `
                            <div>
                                <label class="block text-sm text-gray-400 mb-1">${field.name} *</label>
                                <input type="${field.type}" id="field-${index}-${field.name}" placeholder="Enter ${field.name}" class="${field.type === 'file' ? 'file:mr-4 file:py-1 file:px-3 file:rounded file:border-0 file:bg-gray-700 file:text-white text-sm' : 'w-full bg-cardBg border border-gray-600 rounded p-1.5 text-white outline-none focus:border-primary'}">
                            </div>
                        `;
                    });
                    html += `</div>`;
                }
                // No Payload State
                else if ((ep.method !== 'GET' && ep.fields && ep.fields.length === 0) || (ep.method === 'GET' && !ep
                        .hasParams)) {
                    html += `
                        <div class="mb-4 bg-green-900 bg-opacity-20 border border-green-800 rounded p-3 text-sm text-green-400 flex items-center">
                            <i class="fas fa-check-square mr-2"></i> No Payload Required
                        </div>
                    `;
                }

                // Execute Button & Response Box
                html += `
                                <button onclick="executeRequest(${index})" class="w-full text-center bg-cyan-500 hover:bg-cyan-400 text-white px-6 py-2 rounded shadow-lg transition duration-200 font-semibold mb-4">
                                    Execute Request
                                </button>

                                <div class="mt-4 border-t border-gray-700 pt-4">
                                    <h4 class="text-sm font-semibold text-gray-300 mb-2">Server Response <span id="status-${index}" class="ml-2 px-2 py-0.5 rounded text-xs font-bold bg-gray-700"></span></h4>
                                    <pre id="response-${index}" class="bg-darkBg p-4 rounded border border-gray-600 text-green-400 font-mono text-sm overflow-x-auto min-h-[100px] whitespace-pre-wrap">Waiting for execution...</pre>
                                </div>
                            </div>
                        </div>
                        `;

                container.innerHTML += html;
            });
        }

        // Live URL Updater Function
        function updateLiveUrl(index) {
            const ep = endpoints[index];
            const baseUrl = document.getElementById('baseUrl').value;
            let finalUrl = baseUrl + ep.path;

            if (ep.hasParams && ep.params) {
                ep.params.forEach(param => {
                    const el = document.getElementById(`param-${index}-${param}`);
                    const val = el ? el.value.trim() : '';
                    if (val) {
                        finalUrl = finalUrl.replace(`{${param}}`, val);
                    }
                });
            }

            const urlElement = document.getElementById(`url-text-${index}`);
            if (urlElement) {
                urlElement.textContent = finalUrl;
            }
        }

        // 🌐 دالة تحديث الروابط في الواجهة بأعلى كفاءة لمنع التصاق النصوص
        function updateAllUrls() {
            const baseUrlInput = document.getElementById('baseUrl');
            if (!baseUrlInput) return;

            let baseUrl = baseUrlInput.value.trim().replace(/\/$/, "");

            endpoints.forEach((ep, index) => {
                // 1. الهيدر يعرض فقط المسار النسبي النظيف (مثال: /api/login)
                const headUrlEl = document.getElementById(`endpoint-url-${index}`);
                if (headUrlEl) {
                    headUrlEl.textContent = ep.path;
                }

                // 2. صندوق Request URL الداخلي يعرض الرابط مدمجاً بشكل كامل وسليم
                const detailUrlEl = document.getElementById(`url-text-${index}`);
                if (detailUrlEl) {
                    detailUrlEl.textContent = baseUrl + ep.path;
                }
            });
        }
        // Tabs Logic (DNA Analysis)
        function switchDnaTab(index, tab) {
            document.getElementById(`dna-active-tab-${index}`).value = tab;

            const btnSeq = document.getElementById(`tab-btn-seq-${index}`);
            const btnFile = document.getElementById(`tab-btn-file-${index}`);
            const contentSeq = document.getElementById(`tab-content-seq-${index}`);
            const contentFile = document.getElementById(`tab-content-file-${index}`);

            if (tab === 'sequence') {
                btnSeq.className = "px-4 py-1 text-sm bg-primary text-darkBg rounded font-bold transition";
                btnFile.className = "px-4 py-1 text-sm text-gray-400 hover:text-white transition";
                contentSeq.classList.remove('hidden');
                contentFile.classList.add('hidden');
                document.getElementById(`dna-file-${index}`).value = '';
            } else {
                btnFile.className = "px-4 py-1 text-sm bg-primary text-darkBg rounded font-bold transition";
                btnSeq.className = "px-4 py-1 text-sm text-gray-400 hover:text-white transition";
                contentFile.classList.remove('hidden');
                contentSeq.classList.add('hidden');
                document.getElementById(`dna-seq-${index}`).value = '';
            }
        }

        //  Dynamic Request Executor Engine (Optimized & Final Version)
        async function executeRequest(index) {
            const ep = endpoints[index];

            // 1. تنظيف الـ baseUrl لضمان عدم وجود Slash زائدة في النهاية
            const baseUrlInput = document.getElementById('baseUrl');
            const baseUrl = baseUrlInput ? baseUrlInput.value.trim().replace(/\/$/, "") : "";
            const token = document.getElementById('globalToken').value;
            const responseBox = document.getElementById(`response-${index}`);
            const statusBox = document.getElementById(`status-${index}`);

            responseBox.textContent = "Executing...";
            statusBox.textContent = "WAITING";
            statusBox.className = "ml-2 px-2 py-0.5 rounded text-xs font-bold bg-yellow-600 text-white";

            // 2. بناء مسار الرابط النهائي بذكاء
            const cleanPath = ep.path.startsWith('/') ? ep.path : '/' + ep.path;
            let finalUrl = baseUrl + cleanPath;

            if (ep.hasParams && ep.params) {
                ep.params.forEach(param => {
                    const el = document.getElementById(`param-${index}-${param}`);
                    const val = el ? el.value.trim() : '';
                    if (val) finalUrl = finalUrl.replace(`{${param}}`, encodeURIComponent(val));
                });
            }

            // 3. إعدادات الطلب الأساسية (Headers & Method)
            let fetchMethod = ep.method.toUpperCase();
            const options = {
                method: fetchMethod,
                headers: {
                    'Accept': 'application/json'
                }
            };

            if (token) {
                options.headers['Authorization'] = `Bearer ${token}`;
            }

            // 4. تجهيز البيانات (Payload)
            if (fetchMethod !== 'GET' && fetchMethod !== 'HEAD') {

                let hasFile = false;
                if (ep.fields) {
                    hasFile = ep.fields.some(f => f.type === 'file');
                }

                // === التعديل الجوهري: إجبار الـ DNA Analysis على استخدام FormData ===
                if (hasFile || ep.bodyType === 'formdata' || ep.isDnaAnalysis) {
                    const formData = new FormData();

                    // دعم ملفات الـ PUT/PATCH عبر الـ Method Spoofing الخاص بـ Laravel
                    if (fetchMethod === 'PUT' || fetchMethod === 'PATCH') {
                        options.method = 'POST';
                        formData.append('_method', fetchMethod);
                    }

                    // الحقول العادية إن وجدت
                    if (ep.fields) {
                        ep.fields.forEach(f => {
                            const input = document.getElementById(`field-${index}-${f.name}`);
                            if (!input) return;

                            if (f.type === 'file') {
                                if (input.files && input.files.length > 0) {
                                    formData.append(f.name, input.files[0]);
                                }
                            } else {
                                formData.append(f.name, input.value);
                            }
                        });
                    }

                    // 🧬 معالجة حقول الـ DNA Analysis بأعلى دقة 🧬
                    if (ep.isDnaAnalysis) {
                        const activeTabEl = document.getElementById(`dna-active-tab-${index}`);
                        // الافتراضي هو sequence في حال لم نجد العنصر
                        const activeTab = activeTabEl ? activeTabEl.value : 'sequence';

                        if (activeTab === 'sequence') {
                            const seqInput = document.getElementById(`dna-seq-${index}`);
                            if (seqInput && seqInput.value.trim() !== '') {
                                formData.append('sequence', seqInput.value.trim());
                            }
                        } else {
                            const fileInput = document.getElementById(`dna-file-${index}`);
                            if (fileInput && fileInput.files && fileInput.files.length > 0) {
                                formData.append('file', fileInput.files[0]);
                            }
                        }
                    }

                    options.body = formData;

                    // === التعامل مع JSON العادي ===
                } else {
                    const bodyObj = {};
                    if (ep.fields) {
                        ep.fields.forEach(f => {
                            const input = document.getElementById(`field-${index}-${f.name}`);
                            if (!input) return;

                            let val = input.value;
                            if (f.name === 'data' || (val && (val.startsWith('{') || val.startsWith('[')))) {
                                try {
                                    val = JSON.parse(val);
                                } catch (e) {
                                    console.warn(`Could not parse JSON for ${f.name}`);
                                }
                            }
                            bodyObj[f.name] = val;
                        });
                    }
                    options.body = JSON.stringify(bodyObj);
                    options.headers['Content-Type'] = 'application/json';
                }
            }

            // 5. تنفيذ الطلب (Execution & Error Handling)
            try {
                const res = await fetch(finalUrl, options);

                statusBox.textContent = res.status;
                if (res.ok || res.status === 201) {
                    statusBox.className = "ml-2 px-2 py-0.5 rounded text-xs font-bold bg-green-600 text-white";
                } else if (res.status === 422) { // 422 Unprocessable Entity (Laravel Validation Error)
                    statusBox.className = "ml-2 px-2 py-0.5 rounded text-xs font-bold bg-yellow-500 text-white";
                } else {
                    statusBox.className = "ml-2 px-2 py-0.5 rounded text-xs font-bold bg-red-600 text-white";
                }

                const textData = await res.text();
                try {
                    const jsonData = JSON.parse(textData);
                    responseBox.textContent = JSON.stringify(jsonData, null, 2);
                } catch (e) {
                    responseBox.textContent = textData || "Empty Response from Server";
                }

            } catch (e) {
                statusBox.textContent = "ERROR";
                statusBox.className = "ml-2 px-2 py-0.5 rounded text-xs font-bold bg-red-600 text-white";
                responseBox.textContent = "Network Error, CORS Issue, or Request Failed:\n" + e.toString();
            }
        }

        function toggleDetails(index) {
            const details = document.getElementById(`details-${index}`);
            const icon = document.getElementById(`icon-${index}`);
            details.classList.toggle('hidden');
            if (details.classList.contains('hidden')) {
                icon.style.transform = "rotate(0deg)";
            } else {
                icon.style.transform = "rotate(180deg)";
            }
        }

        window.onload = function() {
            // 🌟 حل ذكي للتفرقة بين بيئة اللوكال وبيئة السيرفر المرفوع 🌟
            const baseUrlInput = document.getElementById('baseUrl');
            if (baseUrlInput) {
                const currentHostname = window.location.hostname;

                // 1. إذا كنا على السيرفر الفعلي المرفوع أونلاين
                if (currentHostname !== 'localhost' && currentHostname !== '127.0.0.1') {
                    baseUrlInput.value = window.location.origin;
                }
                // 2. إذا كنا شغالين لوكال وأنت تريد توجيه الطلبات للإنتاج (Production Server)
                else {
                    // إذا كنت كاتب الرابط بـ http، نحوله فوراً إلى https لمنع مشكلة الـ Redirect وسقوط الـ Methods
                    if (baseUrlInput.value.startsWith('https://fronsicso-production.up.railway.app/')) {
                        baseUrlInput.value = baseUrlInput.value.replace('http://', 'https://');
                    }
                }
            }

            renderUI();
            updateAllUrls();
        };
    </script>
</body>

</html>
