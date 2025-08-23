<footer class="modern-footer">
    <div class="container">
        <!-- Main Footer Content -->
        <div class="footer-main">
            <div class="row align-items-center">
                <!-- Quick Links Section -->
                <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
                    <div class="footer-section">
                        <h5 class="footer-title">Quick Links</h5>
                        <div class="footer-links">
                            <a href="{{ route('dashboard') }}" class="footer-link">Dashboard</a>
                            <a href="{{ route('dashboard.all.approve.exams') }}" class="footer-link">Exam Archives</a>
                            <a href="{{ route('dashboard.all.approve.files') }}" class="footer-link">Academic Files</a>
                            <a href="{{ route('departments.index') }}" class="footer-link">Departments</a>
                        </div>
                    </div>
                </div>

                <!-- Partner Links Section -->
                <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
                    <div class="footer-section">
                        <h5 class="footer-title">Our Partners</h5>
                        <div class="footer-links">
                            <a href="http://academicdigital.space/" target="_blank" rel="noopener" class="footer-link">
                                <i class="icofont-external-link"></i> Metascholar Institute
                            </a>
                            <a href="https://metascholarturnitinmoodle.com/" target="_blank" rel="noopener" class="footer-link">
                                <i class="icofont-external-link"></i> Metascholar Turnitin
                            </a>
                            <a href="https://scholarindexing.com/" target="_blank" rel="noopener" class="footer-link">
                                <i class="icofont-external-link"></i> Scholar Indexing Society
                            </a>
                            <a href="https://ijmsirjournal.com/" target="_blank" rel="noopener" class="footer-link">
                                <i class="icofont-external-link"></i> IJMSIR Journal
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Support Section -->
                <div class="col-lg-4 col-md-12">
                    <div class="footer-section text-lg-end">
                        <h5 class="footer-title">Need Support?</h5>
                        <div class="support-info">
                            <a href="mailto:support@academicdigital.space" class="support-email">
                                <i class="icofont-email"></i>
                                support@academicdigital.space
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Bottom -->
        <div class="footer-bottom">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start">
                    <p class="copyright-text">
                        &copy; {{ date('Y') }} University Exam Archives. All rights reserved.
                    </p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <p class="developed-by">
                        Developed & Powered by 
                        <a href="mailto:support@academicdigital.space" class="metascholar-link">
                            <strong>Metascholar Consult LTD</strong>
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</footer>

<style>
.modern-footer {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-top: 1px solid #dee2e6;
    padding: 0;
    margin-top: auto;
}

.footer-main {
    padding: 2.5rem 0 1.5rem;
}

.footer-section {
    padding: 0 1rem;
}

.footer-title {
    color: #495057;
    font-size: 1.1rem;
    font-weight: 600;
    margin-bottom: 1rem;
    letter-spacing: 0.5px;
}

.footer-links {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.footer-link {
    color: #6c757d;
    text-decoration: none;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 0.3rem;
}

.footer-link:hover {
    color: #007bff;
    text-decoration: none;
    transform: translateX(3px);
}

.footer-link i {
    font-size: 0.8rem;
    opacity: 0.7;
}

.support-info {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.support-email {
    color: #6c757d;
    text-decoration: none;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.support-email:hover {
    color: #007bff;
    text-decoration: none;
}

.support-email i {
    font-size: 1rem;
}

.footer-bottom {
    background: rgba(255, 255, 255, 0.7);
    border-top: 1px solid #e9ecef;
    padding: 1rem 0;
}

.copyright-text,
.developed-by {
    margin: 0;
    font-size: 0.85rem;
    color: #6c757d;
    line-height: 1.4;
}

.metascholar-link {
    color: #495057;
    text-decoration: none;
    transition: all 0.3s ease;
}

.metascholar-link:hover {
    color: #007bff;
    text-decoration: none;
}

.metascholar-link strong {
    font-weight: 600;
}

/* Dark mode support */
.is_dark .modern-footer {
    background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
    border-top: 1px solid #4a5568;
}

.is_dark .footer-title {
    color: #e2e8f0;
}

.is_dark .footer-link,
.is_dark .support-email,
.is_dark .copyright-text,
.is_dark .developed-by {
    color: #a0aec0;
}

.is_dark .footer-link:hover,
.is_dark .support-email:hover,
.is_dark .metascholar-link:hover {
    color: #4299e1;
}

.is_dark .metascholar-link {
    color: #e2e8f0;
}

.is_dark .footer-bottom {
    background: rgba(45, 55, 72, 0.7);
    border-top: 1px solid #4a5568;
}

/* Responsive Design */
@media (max-width: 768px) {
    .footer-main {
        padding: 2rem 0 1rem;
    }
    
    .footer-section {
        padding: 0 0.5rem;
        text-align: center;
        margin-bottom: 1.5rem;
    }
    
    .footer-section.text-lg-end {
        text-align: center !important;
    }
    
    .footer-links {
        align-items: center;
    }
    
    .support-info {
        align-items: center;
    }
    
    .footer-bottom .row > div {
        text-align: center !important;
        margin-bottom: 0.5rem;
    }
    
    .footer-bottom .row > div:last-child {
        margin-bottom: 0;
    }
}

@media (max-width: 576px) {
    .footer-main {
        padding: 1.5rem 0 0.8rem;
    }
    
    .footer-title {
        font-size: 1rem;
        margin-bottom: 0.8rem;
    }
    
    .footer-link,
    .support-email {
        font-size: 0.85rem;
    }
    
    .copyright-text,
    .developed-by {
        font-size: 0.8rem;
    }
}

/* Animation for smooth loading */
.modern-footer {
    animation: fadeInUp 0.6s ease-out;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>