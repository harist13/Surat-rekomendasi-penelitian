<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Persyaratan Penelitian - Kesbangpol Kaltim</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Heroicons -->
    <script src="https://unpkg.com/@heroicons/v2.0.18/24/outline/index.js"></script>
    <!-- jsPDF for generating PDFs -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <!-- html2canvas for capturing elements as images for PDF -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <style>
        /* PDF Template Preview Styles */
        .pdf-preview {
            border: 1px solid #ccc;
            padding: 20px;
            background-color: #f8f8f8;
            border-radius: 4px;
            position: relative;
            max-height: 500px;
            overflow-y: auto;
        }
        .pdf-watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 60px;
            color: rgba(200, 200, 200, 0.3);
            font-weight: bold;
            z-index: 1;
            pointer-events: none;
        }
        .pdf-content {
            position: relative;
            z-index: 2;
            font-family: "Times New Roman", Times, serif;
        }
        .letter-header {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .letter-body {
            line-height: 1.6;
        }
        .letter-footer {
            margin-top: 40px;
            text-align: right;
        }
        .letter-field {
            border-bottom: 1px dotted #999;
            min-width: 150px;
            display: inline-block;
            margin: 0 5px;
        }
        /* PDF modal styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 100;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.7);
        }
        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 800px;
            max-height: 80vh;
            overflow-y: auto;
            border-radius: 8px;
        }
        .close-modal {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }
        .close-modal:hover {
            color: black;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Header -->
    @include('Layout.App.Header')

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 py-8">
        <!-- Breadcrumbs -->
        <div class="text-sm text-gray-600 mb-8 flex items-center space-x-2">
            <a href="#" class="text-blue-600 hover:underline">Beranda</a>
            <span class="text-gray-400">/</span>
            <span class="text-gray-500">Persyaratan Penelitian</span>
        </div>

        <!-- Main Title -->
        <h1 class="text-3xl font-bold text-[#004aad] mb-8">Persyaratan Pengajuan Izin Penelitian</h1>

        <!-- Accordion Section -->
        <div class="space-y-6">
            <!-- Universitas Samarinda -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="accordion-header bg-[#004aad] text-white px-6 py-4 cursor-pointer flex justify-between items-center">
                    <h2 class="text-xl font-semibold">PERSYARATAN PENGAJUAN SURAT REKOMENDASI PENELITIAN MAHASISWA</h2>
                    <svg class="w-6 h-6 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </div>
                <div class="accordion-content px-6 py-4 border-t border-gray-200">
                    <div class="space-y-4">
                        <div class="mt-4 p-4 bg-blue-50 rounded-lg">
                            <div class="flex items-start">
                                <div class="w-6 flex-shrink-0 text-[#004aad] mt-1">➤</div>
                                <div class="w-full">
                                    <h3 class="font-semibold text-[#004aad] mb-2">Persyaratan:</h3>
                                    <ul class="list-disc pl-6 space-y-2 text-gray-600">
                                        <li>Surat Pengantar dari Kampus (format sesuai template)</li>
                                        <li>Foto Copy KTP Peneliti</li>
                                        <li>Proposal Penelitian</li>
                                    </ul>
                                    
                                </div>
                            </div>
                        </div>
                        
                        
                        
                        <!-- PDF Template Button for Universitas Samarinda -->
                        <div class="mt-6 flex flex-col sm:flex-row sm:items-center gap-4">
                            <button class="view-pdf-btn flex items-center justify-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500" data-template="universitas">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                Lihat Template PDF
                            </button>
                           
                        </div>
                    </div>
                </div>
            </div>

            

            <!-- Lembaga Survei -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="accordion-header bg-[#004aad] text-white px-6 py-4 cursor-pointer flex justify-between items-center">
                    <h2 class="text-xl font-semibold">PERSYARATAN PENGAJUAN SURAT PENERBITAN REKOMNDASI PENELITIAN BAGI NON MAHASISWA</h2>
                    <svg class="w-6 h-6 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </div>
                <div class="accordion-content px-6 py-4 border-t border-gray-200">
                    <div class="space-y-4">
                        <div class="mt-4 p-4 bg-blue-50 rounded-lg">
                            <div class="flex items-start">
                                <div class="w-6 flex-shrink-0 text-[#004aad] mt-1">➤</div>
                                <div>
                                    <h3 class="font-semibold mb-2">Persyaratan Khusus:</h3>
                                    <ul class="list-disc pl-6 space-y-2">
                                        <li>Surat Pengantar Dari Instansi</li>
                                        <li>Salinan Akta Notaris</li>
                                        <li>Surat Terdaftar di Kemenkumham</li>
                                        <li>Surat pernyataan memberikan hasil survei</li>
                                        <li>KTP ketua peneliti</li>
                                        <li>Proposal lengkap (maks. 10 halaman)</li>
                                        
                                    </ul>
                                </div>
                            </div>
                        </div>


                        
                        
                        <!-- PDF Template Button for Lembaga Survei -->
                        <div class="mt-6 flex flex-col sm:flex-row sm:items-center gap-4">
                            <button class="view-pdf-btn flex items-center justify-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500" data-template="lembaga">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                Lihat Template PDF
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- General Requirements -->
        <div class="mt-8 bg-white rounded-lg shadow-md p-8">
            <h2 class="text-2xl font-bold text-[#004aad] mb-6">Persyaratan Umum</h2>
            
            <div class="grid md:grid-cols-2 gap-8">
                <div class="flex items-start">
                    <div class="w-8 flex-shrink-0 text-[#004aad] text-xl mt-1">✔</div>
                    <div>
                        <h3 class="font-semibold">Format Dokumen</h3>
                        <p class="text-gray-600 mt-2 text-sm">
                            Semua dokumen dalam format PDF dengan resolusi jelas<br>
                            Maksimal ukuran file: 2MB per dokumen<br>
                       
                        </p>
                    </div>
                </div>

                <div class="flex items-start">
                    <div class="w-8 flex-shrink-0 text-[#004aad] text-xl mt-1">⏳</div>
                    <div>
                        <h3 class="font-semibold">Proses Verifikasi</h3>
                        <p class="text-gray-600 mt-2 text-sm">
                            Waktu proses: 2-3 hari kerja<br>
                            Notifikasi via SMS/Email<br>
                           
                        </p>
                    </div>
                </div>
            </div>

            <div class="mt-6 p-4 bg-green-50 rounded-lg border border-green-200">
                <h3 class="font-semibold text-green-800 mb-2">📌 Tips Pengajuan Sukses:</h3>
                <ul class="list-disc pl-6 text-sm text-green-700 space-y-2">
                    <li>Periksa kelengkapan dokumen sebelum upload</li>
                    <li>Pastikan semua tanda tangan dan stempel valid</li>
                    <li>Konfirmasi via telepon (0541) 123-4567 ext.123 jika perlu</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- PDF Modal -->
    <div id="pdfModal" class="modal">
        <div class="modal-content">
            <span class="close-modal">&times;</span>
            <h2 class="text-2xl font-bold text-[#004aad] mb-4" id="modalTitle">Template Surat</h2>
            <div id="pdfPreview" class="pdf-preview">
                <!-- PDF content will be loaded here -->
            </div>
            <div class="mt-6 flex justify-center">
                <button id="modalDownloadBtn" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                    Download Template PDF
                </button>
            </div>
        </div>
    </div>

    <!-- Footer -->
    @include('Layout.App.Footer')

    <!-- Hidden Template Components (These will be used to generate PDFs) -->
    <div id="universitas-template" class="hidden">
    <div class="pdf-content">
        <div class="letter-header">
            <div style="text-align: center; font-size: 18px; font-weight: bold;">LOGO KOP SURAT</div>
            <div style="text-align: center; font-size: 16px; font-weight: bold; margin-top: 8px;">UNIVERSITAS</div>
            <div style="text-align: center; font-size: 12px; margin-top: 8px;">ALAMAT UNIVERSITAS</div>
            <div style="border-bottom: 1px solid #000; margin: 15px 0;"></div>
        </div>
        <div class="letter-body">
            <p>Nomor Surat : ________________</p>
            <p>Lampiran : ________________</p>
            <p>Perihal : Permohonan Rekomendasi Penelitian</p>
            <p>Kepada Yth : Kepala Badan Kesatuan Bangsa Dan Politik Prov. Kaltim</p>
            <p>Di</p>
            <p style="text-decoration: underline;">Samarinda</p>
            <p style="margin-top: 16px;">Dengan Hormat,</p>
            <p style="margin-top: 8px;">Sehubungan dengan penyusunan skripsi yang merupakan tugas akhir bagi mahasiswa Program Sarjana (S1/S2/S3) maka kami mohon kepada Bapak/Ibu agar dapat memberikan ijin kepada mahasiswa kami untuk melaksanakan penelitian.</p>
            <p style="margin-top: 16px;">Adapun mahasiswa yang dimaksud adalah :</p>
            <p>Nama : ________________________</p>
            <p>NIM : ________________________</p>
            <p>Jurusan : ________________________</p>
            <p>Program Studi : ________________________</p>
            <p style="margin-top: 8px;">Judul Proposal Penelitian : ____________________________________________</p>
            <p style="margin-top: 8px;">Lokasi Penelitian :</p>
            <p>1. ________________________</p>
            <p>2. ________________________</p>
            <p>3. ________________________</p>
            <p>4. ________________________</p>
            <p style="margin-top: 8px;">Waktu Penelitian : tgl ____ bln ____ (Sampai Dengan) tgl ____ bln ____ Tahun ____</p>
            <p style="margin-top: 16px;">Demikian permohonan ini kami sampaikan, atas perhatian dan kerja samanya diucapkan terima kasih</p>
        </div>
        <div class="letter-footer">
            <p>Samarinda, _____, _______ Tahun</p>
            <p style="margin-top: 8px;">Mengetahui</p>
            <p>Kepala, Instansi/Institut/Universitas</p>
            <p>Atau Pejabat yang mewakili</p>
            <p style="margin-top: 32px;">(_________________)</p>
        </div>
    </div>
</div>

<div id="lembaga-template" class="hidden">
    <div class="pdf-content">
        <div class="letter-header">
            <div style="text-align: center; font-size: 18px; font-weight: bold;">LOGO KOP SURAT</div>
            <div style="text-align: center; font-size: 16px; font-weight: bold; margin-top: 8px;">LEMBAGA SURVEI</div>
            <div style="text-align: center; font-size: 12px; margin-top: 8px;">ALAMAT DOMISILI LEMBAGA SURVEI</div>
            <div style="border-bottom: 1px solid #000; margin: 15px 0;"></div>
        </div>
        <div class="letter-body">
            <p>Nomor Surat : ________________</p>
            <p>Lampiran : ________________</p>
            <p>Perihal : Permohonan Rekomendasi Penelitian / Survei</p>
            <p>Kepada Yth : Kepala Badan Kesatuan Bangsa Dan Politik Prov. Kaltim</p>
            <p>Di</p>
            <p style="text-decoration: underline;">Samarinda</p>
            <p style="margin-top: 16px;">Dengan Hormat,</p>
            <p style="margin-top: 8px;">..................................... KATA PENGANTAR ...................................</p>
            <p style="margin-top: 16px;">Adapun Peneliti yang dimaksud adalah :</p>
            <p>Nama : ________________________</p>
            <p>Jabatan : ________________________</p>
            <p>Alamat Peneliti : ________________________</p>
            <p>Nomor Telepon/HP : ________________________</p>
            <p style="margin-top: 8px;">Judul Proposal Penelitian : ____________________________________________</p>
            <p style="margin-top: 8px;">Lokasi Penelitian : Provinsi Kalimantan Timur / Kabupaten/Kota</p>
            <p>1. ________________________</p>
            <p>2. ________________________</p>
            <p>3. ________________________</p>
            <p style="margin-top: 8px;">Waktu Penelitian : tgl ____ bln ____ (Sampai Dengan) tgl ____ bln ____ Tahun ____</p>
            <p style="margin-top: 8px;">Anggota Tim Penelitian : __________, __________, __________, __________</p>
            <p style="margin-top: 8px;">Tujuan Penelitian : ____________________________________________</p>
            <p style="margin-top: 8px;">Nomor Telepon/HP : ____________________________________________</p>
            <p style="margin-top: 16px;">Demikian permohonan ini kami sampaikan, atas perhatian dan kerja samanya diucapkan terima kasih</p>
        </div>
        <div class="letter-footer">
            <p>Samarinda, _____, _______ Tahun</p>
            <p style="margin-top: 8px;">Mengetahui</p>
            <p>Kepala, Instansi/Lembaga Survei</p>
            <p>Atau Pejabat yang mewakili</p>
            <p style="margin-top: 32px;">(_________________)</p>
        </div>
    </div>
</div>

    <script>
    // Make jsPDF available globally
    const { jsPDF } = window.jspdf;

    // Accordion functionality
    document.querySelectorAll('.accordion-header').forEach(header => {
        header.addEventListener('click', () => {
            const content = header.nextElementSibling;
            const icon = header.querySelector('svg');
            
            icon.classList.toggle('rotate-180');
            content.classList.toggle('hidden');
        });
    });
    
    // Track current active PDF viewer
    let currentActiveViewer = null;
    
    // View PDF functionality
    document.querySelectorAll('.view-pdf-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const templateType = btn.getAttribute('data-template');
            
            // Find the parent container (accordion content)
            const accordionContent = btn.closest('.accordion-content');
            
            // Check if viewer already exists
            let pdfViewerContainer = accordionContent.querySelector('.pdf-viewer-container');
            
            // If there's already an active viewer elsewhere, remove it first
            if (currentActiveViewer && currentActiveViewer !== pdfViewerContainer) {
                currentActiveViewer.remove();
                currentActiveViewer = null;
            }
            
            // If viewer already exists in this section, just toggle it
            if (pdfViewerContainer) {
                pdfViewerContainer.remove();
                currentActiveViewer = null;
                btn.textContent = 'Lihat Template PDF';
                btn.classList.remove('bg-red-600', 'hover:bg-red-700');
                btn.classList.add('bg-blue-600', 'hover:bg-blue-700');
                return;
            }
            
            // Create new viewer container
            pdfViewerContainer = document.createElement('div');
            pdfViewerContainer.className = 'pdf-viewer-container mt-6 bg-white rounded-lg shadow-lg overflow-hidden w-full max-w-4xl mx-auto';
            pdfViewerContainer.style.transition = 'all 0.3s ease';
            
            // Create header for the viewer
            const viewerHeader = document.createElement('div');
            viewerHeader.className = 'flex items-center justify-between bg-gray-100 px-6 py-3 border-b border-gray-200';
            
            // Add title based on template type
            const viewerTitle = document.createElement('h3');
            viewerTitle.className = 'font-semibold text-gray-800 text-lg';
            viewerTitle.textContent = templateType === 'universitas' ? 
                'Template Surat Pengantar Universitas' : 'Template Surat Lembaga Survei';
            viewerHeader.appendChild(viewerTitle);
            
            // Add actions container
            const actionsContainer = document.createElement('div');
            actionsContainer.className = 'flex items-center space-x-3';
            
            // Add download button directly in the viewer
            const downloadBtn = document.createElement('button');
            downloadBtn.className = 'text-sm text-white bg-green-600 hover:bg-green-700 px-3 py-1 rounded flex items-center';
            downloadBtn.innerHTML = '<svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>Download';
            downloadBtn.setAttribute('data-template', templateType);
            downloadBtn.onclick = function() {
                downloadPDF(templateType, this);
            };
            actionsContainer.appendChild(downloadBtn);
            
            // Add close button
            const closeBtn = document.createElement('button');
            closeBtn.className = 'text-gray-500 hover:text-gray-800 focus:outline-none hover:bg-gray-200 p-1 rounded-full transition-colors';
            closeBtn.innerHTML = '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>';
            closeBtn.onclick = function() {
                pdfViewerContainer.remove();
                currentActiveViewer = null;
                btn.textContent = 'Lihat Template PDF';
                btn.classList.remove('bg-red-600', 'hover:bg-red-700');
                btn.classList.add('bg-blue-600', 'hover:bg-blue-700');
            };
            actionsContainer.appendChild(closeBtn);
            
            viewerHeader.appendChild(actionsContainer);
            
            // Add header to container
            pdfViewerContainer.appendChild(viewerHeader);
            
            // Create iframe wrapper for better control
            const iframeWrapper = document.createElement('div');
            iframeWrapper.className = 'relative w-full';
            iframeWrapper.style.height = '650px'; // Taller iframe
            
            // Create iframe for PDF viewer
            const pdfFrame = document.createElement('iframe');
            pdfFrame.className = 'absolute inset-0 w-full h-full border-0';
            pdfFrame.style.backgroundColor = '#f0f0f0';
            iframeWrapper.appendChild(pdfFrame);
            
            // Add loading indicator
            const loadingIndicator = document.createElement('div');
            loadingIndicator.className = 'absolute inset-0 flex flex-col items-center justify-center bg-white bg-opacity-90';
            loadingIndicator.innerHTML = `
                <svg class="animate-spin -ml-1 mr-3 h-10 w-10 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span class="mt-3 text-blue-600 font-medium">Memuat PDF...</span>
            `;
            iframeWrapper.appendChild(loadingIndicator);
            
            // Add iframe wrapper to container
            pdfViewerContainer.appendChild(iframeWrapper);
            
            // Find the best place to insert the PDF viewer (after the buttons container)
            const buttonContainer = btn.closest('.flex');
            
            // Make sure we insert after the entire buttons container
            buttonContainer.parentNode.insertBefore(pdfViewerContainer, buttonContainer.nextSibling);
            
            // Remember this viewer as active
            currentActiveViewer = pdfViewerContainer;
            
            // Update button text and style to indicate active state
            btn.textContent = 'Tutup Template PDF';
            btn.classList.remove('bg-blue-600', 'hover:bg-blue-700');
            btn.classList.add('bg-red-600', 'hover:bg-red-700');
            
            // Generate and display PDF
            generatePDFForViewer(templateType).then(pdfBlob => {
                // Create object URL from blob
                const pdfUrl = URL.createObjectURL(pdfBlob);
                
                // Set iframe source to the PDF URL
                pdfFrame.src = pdfUrl;
                
                // Remove loading indicator when iframe loads
                pdfFrame.onload = function() {
                    loadingIndicator.remove();
                };
            }).catch(error => {
                console.error("Error generating PDF:", error);
                loadingIndicator.innerHTML = `
                    <svg class="h-12 w-12 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <div class="mt-3 text-red-600 font-medium">Gagal memuat PDF. Silakan coba lagi.</div>
                    <button class="mt-2 px-3 py-1 bg-blue-600 text-white rounded text-sm hover:bg-blue-700">Coba Lagi</button>
                `;
                
                // Add retry functionality
                loadingIndicator.querySelector('button').onclick = function() {
                    loadingIndicator.innerHTML = `
                        <svg class="animate-spin -ml-1 mr-3 h-10 w-10 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span class="mt-3 text-blue-600 font-medium">Mencoba kembali...</span>
                    `;
                    
                    generatePDFForViewer(templateType).then(pdfBlob => {
                        const pdfUrl = URL.createObjectURL(pdfBlob);
                        pdfFrame.src = pdfUrl;
                        pdfFrame.onload = function() {
                            loadingIndicator.remove();
                        };
                    }).catch(error => {
                        loadingIndicator.innerHTML = `
                            <svg class="h-12 w-12 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            <div class="mt-3 text-red-600 font-medium">Gagal memuat PDF lagi. Silakan coba nanti.</div>
                        `;
                    });
                };
            });
        });
    });
    
    // Direct download functionality
    document.querySelectorAll('.download-pdf-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const templateType = btn.getAttribute('data-template');
            downloadPDF(templateType, btn);
        });
    });
    
    // Function to generate PDF for download
    function downloadPDF(templateType, buttonElement) {
        // Store original text
        const originalText = buttonElement.innerHTML;
        
        // Show loading state
        buttonElement.innerHTML = '<svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Menyiapkan...';
        buttonElement.disabled = true;
        
        generatePDFForViewer(templateType).then(pdfBlob => {
            // Create a temporary link to trigger download
            const link = document.createElement('a');
            link.href = URL.createObjectURL(pdfBlob);
            link.download = templateType === 'universitas' ? 
                'Template_Surat_Pengantar_Universitas.pdf' : 
                'Template_Surat_Lembaga_Survei.pdf';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            
            // Show success message
            buttonElement.innerHTML = '<svg class="h-4 w-4 mr-2 text-white inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>Berhasil';
            
            // Reset button after delay
            setTimeout(() => {
                buttonElement.innerHTML = originalText;
                buttonElement.disabled = false;
            }, 2000);
        }).catch(error => {
            console.error("Error downloading PDF:", error);
            buttonElement.innerHTML = '<svg class="h-4 w-4 mr-2 text-white inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>Gagal';
            setTimeout(() => {
                buttonElement.innerHTML = originalText;
                buttonElement.disabled = false;
            }, 2000);
        });
    }
    
    // Function to generate PDF and return a Promise with the PDF blob
    function generatePDFForViewer(templateType) {
    return new Promise((resolve, reject) => {
        // Inisialisasi dokumen PDF
        const doc = new jsPDF({
            orientation: 'portrait',
            unit: 'mm',
            format: 'a4'
        });

        // Jarak standar
        const leftMargin = 20;
        const centerPosition = 105;
        const rightMargin = 190;
        
        // Jarak vertikal
        const headerSpacing = 10;
        const paragraphSpacing = 8;
        const lineSpacing = 6;
        
        let currentY = 20; // Posisi Y awal

        if (templateType === 'universitas') {
            // ===== HEADER =====
            // Menambahkan teks untuk template universitas
            doc.setFontSize(18);
            doc.text("LOGO KOP SURAT", centerPosition, currentY, { align: "center" });
            currentY += headerSpacing;
            
            doc.setFontSize(16);
            doc.text("UNIVERSITAS", centerPosition, currentY, { align: "center" });
            currentY += headerSpacing;
            
            doc.setFontSize(12);
            doc.text("ALAMAT UNIVERSITAS", centerPosition, currentY, { align: "center" });
            currentY += headerSpacing;
            
            // Garis bawah header
            doc.line(10, currentY, 200, currentY);
            currentY += 10; // Jarak setelah garis
            
            // ===== INFORMASI SURAT =====
            doc.setFontSize(12);
            doc.text("Nomor Surat : ________________", leftMargin, currentY);
            currentY += lineSpacing;
            
            doc.text("Lampiran : ________________", leftMargin, currentY);
            currentY += lineSpacing;
            
            doc.text("Perihal : Permohonan Rekomendasi Penelitian", leftMargin, currentY);
            currentY += lineSpacing + 2;
            
            doc.text("Kepada Yth :", leftMargin, currentY);
            currentY += lineSpacing;
            
            doc.text("Kepala Badan Kesatuan Bangsa Dan Politik Prov. Kaltim", leftMargin, currentY);
            currentY += lineSpacing;
            
            doc.text("Di", leftMargin, currentY);
            currentY += lineSpacing;
            
            doc.text("Samarinda", leftMargin, currentY);
            currentY += paragraphSpacing;
            
            // ===== ISI SURAT =====
            doc.text("Dengan Hormat,", leftMargin, currentY);
            currentY += paragraphSpacing;
            
            doc.text("Sehubungan dengan penyusunan skripsi yang merupakan tugas akhir bagi mahasiswa Program Sarjana (S1/S2/S3), kami mohon kepada Bapak/Ibu agar dapat memberikan izin kepada mahasiswa kami untuk melaksanakan penelitian.", 
                leftMargin, currentY, { maxWidth: rightMargin - leftMargin });
            currentY += paragraphSpacing + 10; // Jarak tambahan setelah paragraf panjang
            
            doc.text("Adapun mahasiswa yang dimaksud adalah :", leftMargin, currentY);
            currentY += paragraphSpacing;
            
            // ===== DATA MAHASISWA =====
            doc.text("Nama : ________________________", leftMargin, currentY);
            currentY += lineSpacing;
            
            doc.text("NIM : ________________________", leftMargin, currentY);
            currentY += lineSpacing;
            
            doc.text("Jurusan : ________________________", leftMargin, currentY);
            currentY += lineSpacing;
            
            doc.text("Program Studi : ________________________", leftMargin, currentY);
            currentY += lineSpacing;
            
            doc.text("Judul Proposal Penelitian : ____________________________________________", leftMargin, currentY);
            currentY += paragraphSpacing + 4;
            
            // ===== LOKASI PENELITIAN =====
            doc.text("Lokasi Penelitian :", leftMargin, currentY);
            currentY += lineSpacing;
            
            doc.text("1. ________________________", leftMargin, currentY);
            currentY += lineSpacing;
            
            doc.text("2. ________________________", leftMargin, currentY);
            currentY += lineSpacing;
            
            doc.text("3. ________________________", leftMargin, currentY);
            currentY += lineSpacing;
            
            doc.text("4. ________________________", leftMargin, currentY);
            currentY += lineSpacing;
            
            doc.text("Waktu Penelitian : tgl ____ bln ____ (Sampai Dengan) tgl ____ bln ____ Tahun ____", leftMargin, currentY);
            currentY += paragraphSpacing + 4;
            
            // ===== PENUTUP =====
            doc.text("Demikian permohonan ini kami sampaikan, atas perhatian dan kerja samanya diucapkan terima kasih.", 
                leftMargin, currentY, { maxWidth: rightMargin - leftMargin });
            currentY += paragraphSpacing + 14; // Jarak untuk tanda tangan
            
            // ===== BAGIAN TANDA TANGAN =====
            doc.text("Samarinda, _____, _______ Tahun", leftMargin, currentY);
            currentY += lineSpacing;
            
            doc.text("Mengetahui", leftMargin, currentY);
            currentY += lineSpacing;
            
            doc.text("Kepala, Instansi/Institut/Universitas", leftMargin, currentY);
            currentY += lineSpacing;
            
            doc.text("Atau Pejabat yang mewakili", leftMargin, currentY);
            currentY += lineSpacing + 23; // Jarak untuk nama penandatangan
            
            doc.text("(_________________)", leftMargin, currentY);
            
        } else if (templateType === 'lembaga') {
            // ===== HEADER =====
            doc.setFontSize(18);
            doc.text("LOGO KOP SURAT", centerPosition, currentY, { align: "center" });
            currentY += headerSpacing;
            
            doc.setFontSize(16);
            doc.text("LEMBAGA SURVEI", centerPosition, currentY, { align: "center" });
            currentY += headerSpacing;
            
            doc.setFontSize(12);
            doc.text("ALAMAT DOMISILI LEMBAGA SURVEI", centerPosition, currentY, { align: "center" });
            currentY += headerSpacing;
            
            // Garis bawah header
            doc.line(10, currentY, 200, currentY);
            currentY += 10; // Jarak setelah garis
            
            // ===== INFORMASI SURAT =====
            doc.setFontSize(12);
            doc.text("Nomor Surat : ________________", leftMargin, currentY);
            currentY += lineSpacing;
            
            doc.text("Lampiran : ________________", leftMargin, currentY);
            currentY += lineSpacing;
            
            doc.text("Perihal : Permohonan Rekomendasi Penelitian / Survei", leftMargin, currentY);
            currentY += lineSpacing + 2;
            
            doc.text("Kepada Yth :", leftMargin, currentY);
            currentY += lineSpacing;
            
            doc.text("Kepala Badan Kesatuan Bangsa Dan Politik Prov. Kaltim", leftMargin, currentY);
            currentY += lineSpacing;
            
            doc.text("Di", leftMargin, currentY);
            currentY += lineSpacing;
            
            doc.text("Samarinda", leftMargin, currentY);
            currentY += paragraphSpacing;
            
            // ===== ISI SURAT =====
            doc.text("Dengan Hormat,", leftMargin, currentY);
            currentY += paragraphSpacing;
            
            doc.text("..................................... KATA PENGANTAR ...................................", 
                leftMargin, currentY);
            currentY += paragraphSpacing + 8; // Jarak tambahan setelah paragraf
            
            doc.text("Adapun Peneliti yang dimaksud adalah :", leftMargin, currentY);
            currentY += paragraphSpacing;
            
            // ===== DATA PENELITI =====
            doc.text("Nama : ________________________", leftMargin, currentY);
            currentY += lineSpacing;
            
            doc.text("Jabatan : ________________________", leftMargin, currentY);
            currentY += lineSpacing;
            
            doc.text("Alamat Peneliti : ________________________", leftMargin, currentY);
            currentY += lineSpacing;
            
            doc.text("Nomor Telepon/HP : ________________________", leftMargin, currentY);
            currentY += lineSpacing;
            
            doc.text("Judul Proposal Penelitian : ____________________________________________", leftMargin, currentY);
            currentY += paragraphSpacing + 4;
            
            // ===== LOKASI PENELITIAN =====
            doc.text("Lokasi Penelitian : Provinsi Kalimantan Timur / Kabupaten/Kota", leftMargin, currentY);
            currentY += lineSpacing;
            
            doc.text("1. ________________________", leftMargin, currentY);
            currentY += lineSpacing;
            
            doc.text("2. ________________________", leftMargin, currentY);
            currentY += lineSpacing;
            
            doc.text("3. ________________________", leftMargin, currentY);
            currentY += paragraphSpacing;
            
            doc.text("Waktu Penelitian : tgl ____ bln ____ (Sampai Dengan) tgl ____ bln ____ Tahun ____", leftMargin, currentY);
            currentY += paragraphSpacing;
            
            doc.text("Anggota Tim Penelitian : __________, __________, __________, __________", leftMargin, currentY);
            currentY += lineSpacing;
            
            doc.text("Tujuan Penelitian : ____________________________________________", leftMargin, currentY);
            currentY += lineSpacing;
            
            doc.text("Nomor Telepon/HP : ____________________________________________", leftMargin, currentY);
            currentY += paragraphSpacing + 4;
            
            // ===== PENUTUP =====
            doc.text("Demikian permohonan ini kami sampaikan, atas perhatian dan kerja samanya diucapkan terima kasih.", 
                leftMargin, currentY, { maxWidth: rightMargin - leftMargin });
            currentY += paragraphSpacing + 4;
            
            // ===== BAGIAN TANDA TANGAN =====
            doc.text("Samarinda, _____, _______ Tahun", leftMargin, currentY);
            currentY += lineSpacing;
            
            doc.text("Mengetahui", leftMargin, currentY);
            currentY += lineSpacing;
            
            doc.text("Kepala, Instansi/Lembaga Survei", leftMargin, currentY);
            currentY += lineSpacing;
            
            doc.text("Atau Pejabat yang mewakili", leftMargin, currentY);
            currentY += lineSpacing + 23; // Jarak untuk nama penandatangan
            
            doc.text("(_________________)", leftMargin, currentY);
        }

        // Menghasilkan PDF sebagai blob
        const pdfBlob = doc.output('blob');
        resolve(pdfBlob);
    });
}
</script>
</body>
</html>