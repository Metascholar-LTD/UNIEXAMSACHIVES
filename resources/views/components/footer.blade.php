<!-- Modern Footer Section -->
<footer class="modern-footer">
    <div class="container">
        <!-- Main Footer Content -->
        <div class="footer-main">
            <div class="row">
                <!-- Links Section -->
                <div class="col-lg-8 col-md-7 col-sm-12">
                    <div class="footer-links">
                        <h6 class="footer-title">Our Network</h6>
                        <div class="links-grid">
                            <a href="http://academicdigital.space/" target="_blank" rel="noopener" class="footer-link">
                                <i class="icofont-university"></i>
                                Metascholar Institute
                            </a>
                            <a href="https://metascholarturnitinmoodle.com/" target="_blank" rel="noopener" class="footer-link">
                                <i class="icofont-page"></i>
                                Metascholar Turnitin
                            </a>
                            <a href="https://scholarindexing.com/" target="_blank" rel="noopener" class="footer-link">
                                <i class="icofont-search-document"></i>
                                Scholar Indexing Society
                            </a>
                            <a href="https://ijmsirjournal.com/" target="_blank" rel="noopener" class="footer-link">
                                <i class="icofont-book-alt"></i>
                                IJMSIR Journal
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Contact Section -->
                <div class="col-lg-4 col-md-5 col-sm-12">
                    <div class="footer-contact">
                        <h6 class="footer-title">Support</h6>
                        <div class="contact-info">
                            <a href="mailto:support@academicdigital.space" class="contact-link">
                                <i class="icofont-email"></i>
                                support@academicdigital.space
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Bottom Footer -->
        <div class="footer-bottom">
            <div class="row align-items-center">
                <div class="col-md-8 col-sm-12">
                    <div class="copyright-text">
                        <p>&copy; {{ date('Y') }} All Rights Reserved. Developed and Powered by <strong>Metascholar Consult LTD</strong></p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-12">
                    <div class="footer-year">
                        <span class="year-badge">{{ date('Y') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<style>
/* Modern Footer Styles */
.modern-footer {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    color: #495057;
    padding: 40px 0 20px;
    border-top: 1px solid #dee2e6;
    margin-top: auto;
}

.footer-main {
    margin-bottom: 30px;
}

.footer-title {
    color: #343a40;
    font-size: 16px;
    font-weight: 600;
    margin-bottom: 20px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.links-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 12px;
}

.footer-link {
    display: flex;
    align-items: center;
    padding: 10px 15px;
    background: rgba(255, 255, 255, 0.7);
    border-radius: 8px;
    color: #495057;
    text-decoration: none;
    transition: all 0.3s ease;
    border: 1px solid rgba(0, 0, 0, 0.05);
}

.footer-link:hover {
    background: #ffffff;
    color: #007bff;
    text-decoration: none;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 123, 255, 0.15);
}

.footer-link i {
    margin-right: 10px;
    font-size: 16px;
    color: #6c757d;
    transition: color 0.3s ease;
}

.footer-link:hover i {
    color: #007bff;
}

.footer-contact .contact-info {
    background: rgba(255, 255, 255, 0.7);
    padding: 15px;
    border-radius: 8px;
    border: 1px solid rgba(0, 0, 0, 0.05);
}

.contact-link {
    display: flex;
    align-items: center;
    color: #495057;
    text-decoration: none;
    transition: color 0.3s ease;
}

.contact-link:hover {
    color: #007bff;
    text-decoration: none;
}

.contact-link i {
    margin-right: 10px;
    font-size: 16px;
    color: #28a745;
}

.footer-bottom {
    border-top: 1px solid rgba(0, 0, 0, 0.1);
    padding-top: 20px;
}

.copyright-text p {
    margin: 0;
    color: #6c757d;
    font-size: 14px;
    line-height: 1.5;
}

.copyright-text strong {
    color: #495057;
    font-weight: 600;
}

.footer-year {
    text-align: right;
}

.year-badge {
    background: linear-gradient(135deg, #007bff, #0056b3);
    color: white;
    padding: 8px 16px;
    border-radius: 20px;
    font-weight: 600;
    font-size: 14px;
    display: inline-block;
}

/* Responsive Design */
@media (max-width: 768px) {
    .modern-footer {
        padding: 30px 0 15px;
    }
    
    .links-grid {
        grid-template-columns: 1fr;
        gap: 10px;
    }
    
    .footer-link {
        padding: 12px;
        font-size: 14px;
    }
    
    .footer-year {
        text-align: center;
        margin-top: 15px;
    }
    
    .copyright-text {
        text-align: center;
        margin-bottom: 15px;
    }
    
    .footer-title {
        font-size: 15px;
        margin-bottom: 15px;
    }
}

@media (max-width: 576px) {
    .modern-footer {
        padding: 25px 0 15px;
    }
    
    .footer-link {
        font-size: 13px;
        padding: 10px;
    }
    
    .footer-link i {
        font-size: 14px;
        margin-right: 8px;
    }
    
    .copyright-text p {
        font-size: 13px;
    }
    
    .year-badge {
        padding: 6px 12px;
        font-size: 13px;
    }
}

/* Dark mode support */
.is_dark .modern-footer {
    background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
    color: #ecf0f1;
    border-top-color: #34495e;
}

.is_dark .footer-title {
    color: #ecf0f1;
}

.is_dark .footer-link {
    background: rgba(52, 73, 94, 0.7);
    color: #bdc3c7;
    border-color: rgba(255, 255, 255, 0.1);
}

.is_dark .footer-link:hover {
    background: #34495e;
    color: #3498db;
}

.is_dark .footer-link i {
    color: #95a5a6;
}

.is_dark .footer-link:hover i {
    color: #3498db;
}

.is_dark .footer-contact .contact-info {
    background: rgba(52, 73, 94, 0.7);
    border-color: rgba(255, 255, 255, 0.1);
}

.is_dark .contact-link {
    color: #bdc3c7;
}

.is_dark .contact-link:hover {
    color: #3498db;
}

.is_dark .copyright-text p {
    color: #95a5a6;
}

.is_dark .copyright-text strong {
    color: #ecf0f1;
}

.is_dark .footer-bottom {
    border-top-color: rgba(255, 255, 255, 0.1);
}
</style>