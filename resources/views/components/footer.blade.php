<footer class="modern-footer">
    <div class="container-fluid px-0">
        <!-- Main Footer Content -->
        <div class="footer-content">
    <div class="container">
                <div class="row g-4">
                    <!-- Quick Links Section -->
                    <div class="col-lg-4 col-md-6">
                        <div class="footer-section">
                            <h5 class="footer-title">
                                <i class="icofont-navigation-menu"></i>
                                Quick Navigation
                            </h5>
                            <div class="footer-links">
                                <a href="{{ route('dashboard') }}" class="footer-link">
                                    <i class="icofont-dashboard-web"></i>
                                    <span>Dashboard</span>
                                </a>
                                <a href="{{ route('dashboard.all.approve.exams') }}" class="footer-link">
                                    <i class="icofont-file-document"></i>
                                    <span>Exam Archives</span>
                                </a>
                                <a href="{{ route('dashboard.all.approve.files') }}" class="footer-link">
                                    <i class="icofont-folder-open"></i>
                                    <span>Academic Files</span>
                                </a>
                                <a href="{{ route('departments.index') }}" class="footer-link">
                                    <i class="icofont-building-alt"></i>
                                    <span>Departments</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Partner Network Section -->
                    <div class="col-lg-5 col-md-6">
                        <div class="footer-section">
                            <h5 class="footer-title">
                                <i class="icofont-network"></i>
                                Partner Network
                            </h5>
                            <div class="partner-grid">
                                <a href="http://academicdigital.space/" target="_blank" rel="noopener" class="partner-card">
                                    <div class="partner-icon metascholar-icon">
                                        <img src="https://i.ibb.co/3Ycf1t0k/MS.jpg" alt="Metascholar Institute Logo" class="partner-logo">
                                    </div>
                                    <div class="partner-info">
                                        <span class="partner-name">Metascholar Institute</span>
                                        <span class="partner-desc">Academic Excellence</span>
                </div>
                                    <i class="icofont-external-link external-icon"></i>
                                </a>
                                
                                                                <a href="https://metascholarturnitinmoodle.com/" target="_blank" rel="noopener" class="partner-card">
                                    <div class="partner-icon turnitin-icon">
                                        <img src="https://i.ibb.co/hFhtsYtG/tn.png" alt="Metascholar Turnitin Logo" class="partner-logo">
                        </div>
                                    <div class="partner-info">
                                        <span class="partner-name">Metascholar Turnitin</span>
                                        <span class="partner-desc">Plagiarism Detection</span>
                        </div>
                                    <i class="icofont-external-link external-icon"></i>
                                </a>
                                
                                <a href="https://scholarindexing.com/" target="_blank" rel="noopener" class="partner-card">
                                    <div class="partner-icon scholar-indexing-icon">
                                        <img src="https://i.ibb.co/S1hygwB/logo.png" alt="Scholar Indexing Society Logo" class="partner-logo">
                                    </div>
                                    <div class="partner-info">
                                        <span class="partner-name">Scholar Indexing</span>
                                        <span class="partner-desc">Research Indexing</span>
                                    </div>
                                    <i class="icofont-external-link external-icon"></i>
                                </a>
                                
                                <a href="https://ijmsirjournal.com/" target="_blank" rel="noopener" class="partner-card">
                                    <div class="partner-icon ijmsir-icon">
                                        <img src="https://i.ibb.co/1GtfNBwH/IJMSIR.jpg" alt="IJMSIR Logo" class="partner-logo">
                    </div>
                                    <div class="partner-info">
                                        <span class="partner-name">IJMSIR Journal</span>
                                        <span class="partner-desc">Research Publication</span>
                </div>
                                    <i class="icofont-external-link external-icon"></i>
                                </a>
                        </div>
                    </div>
                </div>

                    <!-- Support & Contact Section -->
                    <div class="col-lg-3 col-md-12">
                        <div class="footer-section">
                            <h5 class="footer-title">
                                <i class="icofont-support-faq"></i>
                                Support Center
                            </h5>
                            <div class="support-center">
                                <div class="support-card">
                                    <div class="support-header">
                                        <i class="icofont-live-support"></i>
                                        <span>Get Help</span>
                        </div>
                                    <p class="support-text">Need assistance? Our support team is here to help you.</p>
                                    <a href="mailto:support@academicdigital.space" class="support-btn">
                                        <i class="icofont-email"></i>
                                        Contact Support
                                    </a>
                                        </div>
                                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Full Width Footer Bottom -->
        <div class="footer-bottom-full">
            <div class="container">
                <div class="footer-bottom-content">
                    <div class="copyright-section">
                        <p class="copyright-text">
                            <i class="icofont-copyright"></i>
                            {{ date('Y') }} University Exam Archives. All rights reserved.
                        </p>
                    </div>
                    <div class="divider"></div>
                    <div class="developed-section">
                        <p class="developed-text">
                            <i class="icofont-rocket-alt-2"></i>
                            Developed & Powered by 
                            <a href="mailto:support@academicdigital.space" class="metascholar-brand">
                                Metascholar Consult LTD
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<style>
.modern-footer {
    background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 50%, #f1f3f4 100%);
    border-top: 2px solid #e9ecef;
    margin-top: auto;
    box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.05);
}

.footer-content {
    padding: 3rem 0 2rem;
    position: relative;
}

.footer-content::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 1px;
    background: linear-gradient(90deg, transparent, #007bff, transparent);
}

.footer-section {
    height: 100%;
    padding: 0 1rem;
}

.footer-title {
    color: #2c3e50;
    font-size: 1.2rem;
    font-weight: 700;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    letter-spacing: 0.5px;
    text-transform: uppercase;
    font-size: 0.95rem;
}

.footer-title i {
    color: #007bff;
    font-size: 1.1rem;
}

/* Quick Links Styling */
.footer-links {
    display: flex;
    flex-direction: column;
    gap: 0.8rem;
}

.footer-link {
    color: #495057;
    text-decoration: none;
    padding: 0.7rem 1rem;
    border-radius: 8px;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    display: flex;
    align-items: center;
    gap: 0.7rem;
    background: rgba(255, 255, 255, 0.5);
    border: 1px solid transparent;
}

.footer-link:hover {
    color: #007bff;
    background: rgba(0, 123, 255, 0.08);
    border-color: rgba(0, 123, 255, 0.2);
    transform: translateX(5px);
    text-decoration: none;
}

.footer-link i {
    font-size: 1rem;
    color: #6c757d;
    transition: color 0.3s ease;
}

.footer-link:hover i {
    color: #007bff;
}

/* Partner Grid Styling */
.partner-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 0.8rem;
}

.partner-card {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: rgba(255, 255, 255, 0.7);
    border: 1px solid #e9ecef;
    border-radius: 10px;
    text-decoration: none;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
}

.partner-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(0, 123, 255, 0.1), transparent);
    transition: left 0.5s ease;
}

.partner-card:hover::before {
    left: 100%;
}

.partner-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 123, 255, 0.15);
    border-color: rgba(0, 123, 255, 0.3);
    text-decoration: none;
}

.partner-icon {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #007bff, #0056b3);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.partner-icon i {
    color: white;
    font-size: 1.1rem;
}

.ijmsir-icon,
.metascholar-icon,
.scholar-indexing-icon,
.turnitin-icon {
    background: transparent !important;
    padding: 2px;
    border: 1px solid #495057;
    border-radius: 8px;
    overflow: hidden;
}

.partner-logo {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 4px;
    transition: transform 0.3s ease;
}

.partner-card:hover .partner-logo {
    transform: scale(1.05);
}

.partner-info {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 0.2rem;
}

.partner-name {
    font-weight: 600;
    color: #2c3e50;
    font-size: 0.9rem;
}

.partner-desc {
    font-size: 0.75rem;
    color: #6c757d;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.external-icon {
    color: #6c757d;
    font-size: 0.9rem;
    transition: all 0.3s ease;
}

.partner-card:hover .external-icon {
    color: #007bff;
    transform: translateX(3px);
}

/* Support Center Styling */
.support-center {
    width: 100%;
}

.support-card {
    background: rgba(255, 255, 255, 0.8);
    border: 1px solid #e9ecef;
    border-radius: 12px;
    padding: 1.5rem;
    text-align: center;
    transition: all 0.3s ease;
}

.support-card:hover {
    box-shadow: 0 8px 25px rgba(0, 123, 255, 0.1);
    border-color: rgba(0, 123, 255, 0.2);
}

.support-header {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    margin-bottom: 1rem;
    color: #2c3e50;
    font-weight: 600;
}

.support-header i {
    color: #007bff;
    font-size: 1.2rem;
}

.support-text {
    color: #6c757d;
    font-size: 0.85rem;
    margin-bottom: 1.2rem;
    line-height: 1.5;
}

.support-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: linear-gradient(135deg, #007bff, #0056b3);
    color: white;
    text-decoration: none;
    padding: 0.7rem 1.2rem;
    border-radius: 25px;
    font-weight: 500;
    font-size: 0.85rem;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    border: none;
}

.support-btn:hover {
    background: linear-gradient(135deg, #0056b3, #004085);
    transform: translateY(-1px);
    box-shadow: 0 4px 15px rgba(0, 123, 255, 0.3);
    color: white;
    text-decoration: none;
}

/* Full Width Footer Bottom */
.footer-bottom-full {
    background: linear-gradient(135deg, #e9ecef 0%, #f8f9fa 100%);
    border-top: 1px solid #dee2e6;
    padding: 1.2rem 0;
    margin-top: 0;
}

.footer-bottom-content {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 2rem;
    flex-wrap: wrap;
}

.copyright-section,
.developed-section {
    flex: 1;
    min-width: 200px;
}

.divider {
    width: 1px;
    height: 30px;
    background: linear-gradient(to bottom, transparent, #dee2e6, transparent);
    flex-shrink: 0;
}

.copyright-text,
.developed-text {
    margin: 0;
    font-size: 0.85rem;
    color: #6c757d;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    line-height: 1.4;
}

.copyright-text {
    justify-content: flex-start;
}

.developed-text {
    justify-content: flex-end;
}

.copyright-text i,
.developed-text i {
    color: #007bff;
}

.metascholar-brand {
    color: #2c3e50;
    text-decoration: none;
    font-weight: 700;
    transition: all 0.3s ease;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.metascholar-brand:hover {
    color: #007bff;
    text-decoration: none;
}

/* Dark Mode Support */
.is_dark .modern-footer {
    background: linear-gradient(135deg, #2c3e50 0%, #34495e 50%, #2c3e50 100%);
    border-top: 2px solid #4a5568;
    box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.3);
}

.is_dark .footer-content::before {
    background: linear-gradient(90deg, transparent, #4299e1, transparent);
}

.is_dark .footer-title {
    color: #e2e8f0;
}

.is_dark .footer-title i {
    color: #4299e1;
}

.is_dark .footer-link {
    color: #a0aec0;
    background: rgba(45, 55, 72, 0.5);
}

.is_dark .footer-link:hover {
    color: #4299e1;
    background: rgba(66, 153, 225, 0.15);
    border-color: rgba(66, 153, 225, 0.3);
}

.is_dark .partner-card {
    background: rgba(45, 55, 72, 0.7);
    border-color: #4a5568;
}

.is_dark .partner-card:hover {
    border-color: rgba(66, 153, 225, 0.4);
    box-shadow: 0 8px 25px rgba(66, 153, 225, 0.2);
}

.is_dark .partner-name {
    color: #e2e8f0;
}

.is_dark .partner-desc {
    color: #a0aec0;
}

.is_dark .support-card {
    background: rgba(45, 55, 72, 0.8);
    border-color: #4a5568;
}

.is_dark .support-header {
    color: #e2e8f0;
}

.is_dark .support-text {
    color: #a0aec0;
}

.is_dark .footer-bottom-full {
    background: linear-gradient(135deg, #4a5568 0%, #2d3748 100%);
    border-top: 1px solid #4a5568;
}

.is_dark .divider {
    background: linear-gradient(to bottom, transparent, #4a5568, transparent);
}

.is_dark .copyright-text,
.is_dark .developed-text {
    color: #a0aec0;
}

.is_dark .copyright-text i,
.is_dark .developed-text i {
    color: #4299e1;
}

.is_dark .metascholar-brand {
    color: #e2e8f0;
}

.is_dark .metascholar-brand:hover {
    color: #4299e1;
}

.is_dark .ijmsir-icon,
.is_dark .metascholar-icon,
.is_dark .scholar-indexing-icon,
.is_dark .turnitin-icon {
    border-color: #a0aec0;
}

/* Responsive Design */
@media (max-width: 992px) {
    .footer-content {
        padding: 2.5rem 0 1.5rem;
    }
    
    .partner-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 768px) {
    .footer-content {
        padding: 2rem 0 1rem;
    }
    
    .footer-section {
        padding: 0 0.5rem;
        margin-bottom: 2rem;
    }
    
    .partner-grid {
        grid-template-columns: 1fr;
    }
    
    .footer-bottom-content {
        flex-direction: column;
        text-align: center;
        gap: 1rem;
    }
    
    .divider {
        width: 50px;
        height: 1px;
        background: linear-gradient(to right, transparent, #dee2e6, transparent);
    }
    
    .copyright-text,
    .developed-text {
        justify-content: center;
    }
    
    .is_dark .divider {
        background: linear-gradient(to right, transparent, #4a5568, transparent);
    }
}

@media (max-width: 576px) {
    .footer-content {
        padding: 1.5rem 0 1rem;
    }
    
    .footer-title {
        font-size: 0.9rem;
        margin-bottom: 1rem;
    }
    
    .footer-link {
        padding: 0.6rem 0.8rem;
        font-size: 0.85rem;
    }
    
    .partner-card {
        padding: 0.8rem;
    }
    
    .partner-name {
        font-size: 0.85rem;
    }
    
    .support-card {
        padding: 1.2rem;
    }
    
    .copyright-text,
    .developed-text {
        font-size: 0.8rem;
    }
}

/* Smooth Animations */
.modern-footer {
    animation: slideInUp 0.8s cubic-bezier(0.4, 0, 0.2, 1);
}

@keyframes slideInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Accessibility improvements */
@media (prefers-reduced-motion: reduce) {
    * {
        animation-duration: 0.01ms !important;
        animation-iteration-count: 1 !important;
        transition-duration: 0.01ms !important;
    }
}
</style>