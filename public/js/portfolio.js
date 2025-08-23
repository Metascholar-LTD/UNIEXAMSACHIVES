// Modern Portfolio JavaScript Functionality
document.addEventListener('DOMContentLoaded', function() {
    // Initialize portfolio functionality
    initializePortfolio();
    initializeFilters();
    initializeViewToggle();
    initializeSearch();
    initializePagination();
    initializePreview();
});

function initializePortfolio() {
    // Portfolio initialization code
    console.log('Modern Portfolio initialized');
    
    // Add smooth scrolling to anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
}

function initializeFilters() {
    // Filter functionality
    const filterCheckboxes = document.querySelectorAll('.filter-checkbox');
    const documentCards = document.querySelectorAll('.document-card');
    const activeFiltersContainer = document.getElementById('activeFilters');
    const clearFiltersBtn = document.getElementById('clearFilters');
    const resultsCount = document.querySelector('.results-count');
    
    filterCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', handleFilterChange);
    });
    
    clearFiltersBtn?.addEventListener('click', clearAllFilters);
    
    function handleFilterChange() {
        const activeFilters = getActiveFilters();
        updateActiveFilterTags(activeFilters);
        filterDocuments(activeFilters);
        updateResultsCount();
        
        // Add loading animation
        showLoadingState();
        setTimeout(() => {
            hideLoadingState();
        }, 300);
    }
    
    function getActiveFilters() {
        const filters = {};
        filterCheckboxes.forEach(checkbox => {
            if (checkbox.checked) {
                const type = checkbox.className.includes('faculty-checkbox') ? 'faculty' :
                           checkbox.className.includes('semester-checkbox') ? 'semester' :
                           checkbox.className.includes('year-checkbox') ? 'year' :
                           checkbox.className.includes('tag-checkbox') ? 'tags' :
                           checkbox.name === 'document_type' ? 'document_type' : 'other';
                
                if (!filters[type]) filters[type] = [];
                filters[type].push(checkbox.value);
            }
        });
        return filters;
    }
    
    function updateActiveFilterTags(filters) {
        if (!activeFiltersContainer) return;
        
        activeFiltersContainer.innerHTML = '';
        let hasFilters = false;
        
        Object.entries(filters).forEach(([type, values]) => {
            values.forEach(value => {
                hasFilters = true;
                const tag = document.createElement('div');
                tag.className = 'filter-tag';
                tag.innerHTML = `
                    <span class="filter-tag-label">${value}</span>
                    <button class="filter-tag-remove" onclick="removeFilter('${type}', '${value}')">
                        <i class="fas fa-times"></i>
                    </button>
                `;
                activeFiltersContainer.appendChild(tag);
            });
        });
        
        if (clearFiltersBtn) {
            clearFiltersBtn.style.display = hasFilters ? 'block' : 'none';
        }
    }
    
    function filterDocuments(filters) {
        let visibleCount = 0;
        
        documentCards.forEach(card => {
            let shouldShow = true;
            
            Object.entries(filters).forEach(([type, values]) => {
                if (type === 'document_type') {
                    if (!values.includes(card.dataset.type)) shouldShow = false;
                } else if (type === 'faculty') {
                    if (card.dataset.faculty && !values.includes(card.dataset.faculty)) shouldShow = false;
                } else if (type === 'semester') {
                    if (card.dataset.semester && !values.includes(card.dataset.semester)) shouldShow = false;
                } else if (type === 'year') {
                    if (card.dataset.year && !values.includes(card.dataset.year)) shouldShow = false;
                } else if (type === 'tags') {
                    const cardTags = (card.dataset.tags || '').split(',').map(tag => tag.trim()).filter(tag => tag);
                    if (cardTags.length > 0 && !values.some(value => cardTags.includes(value))) shouldShow = false;
                }
            });
            
            if (shouldShow) {
                card.style.display = 'block';
                card.style.opacity = '0';
                setTimeout(() => {
                    card.style.opacity = '1';
                }, 50);
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });
        
        // Update empty state
        updateEmptyState(visibleCount === 0);
    }
    
    function clearAllFilters() {
        filterCheckboxes.forEach(checkbox => checkbox.checked = false);
        handleFilterChange();
    }
    
    function updateResultsCount() {
        const visibleCards = Array.from(documentCards).filter(card => 
            card.style.display !== 'none'
        );
        
        if (resultsCount) {
            resultsCount.textContent = visibleCards.length;
        }
        
        // Update pagination info
        const paginationInfo = document.querySelector('.pagination-info');
        if (paginationInfo) {
            const total = visibleCards.length;
            const showing = Math.min(20, total);
            paginationInfo.innerHTML = `Showing <strong>1-${showing}</strong> of <strong>${total}</strong> documents`;
        }
    }
    
    function updateEmptyState(isEmpty) {
        const emptyState = document.querySelector('.empty-state-container');
        const documentGrid = document.querySelector('.document-grid-container');
        
        if (isEmpty) {
            if (!emptyState) {
                const emptyStateHTML = `
                    <div class="empty-state-container">
                        <div class="empty-state">
                            <div class="empty-icon">
                                <i class="fas fa-search"></i>
                            </div>
                            <h3 class="empty-title">No Documents Found</h3>
                            <p class="empty-description">No documents match your current filter criteria. Try adjusting your filters or search terms.</p>
                            <button class="clear-filters-btn" onclick="clearAllFilters()">
                                <i class="fas fa-refresh"></i>
                                <span>Clear All Filters</span>
                            </button>
                        </div>
                    </div>
                `;
                documentGrid.insertAdjacentHTML('afterend', emptyStateHTML);
            }
        } else {
            const existingEmptyState = document.querySelector('.empty-state-container');
            if (existingEmptyState) {
                existingEmptyState.remove();
            }
        }
    }
    
    // Global function for removing individual filters
    window.removeFilter = function(type, value) {
        const checkbox = Array.from(filterCheckboxes).find(cb => 
            cb.value === value && 
            (cb.className.includes(`${type}-checkbox`) || cb.name === type)
        );
        if (checkbox) {
            checkbox.checked = false;
            handleFilterChange();
        }
    };
    
    window.clearAllFilters = clearAllFilters;
}

function initializeViewToggle() {
    const viewToggleBtns = document.querySelectorAll('.view-toggle');
    const documentGrid = document.getElementById('documentGrid');
    
    viewToggleBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            viewToggleBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            const view = this.dataset.view;
            if (documentGrid) {
                documentGrid.dataset.view = view;
                
                // Add animation class
                documentGrid.style.opacity = '0.7';
                setTimeout(() => {
                    documentGrid.style.opacity = '1';
                }, 150);
            }
        });
    });
}

function initializeSearch() {
    const searchForm = document.querySelector('.search-form');
    const searchInput = document.querySelector('.search-input');
    
    if (searchInput) {
        // Add search suggestions (simple implementation)
        searchInput.addEventListener('input', function() {
            const query = this.value.toLowerCase();
            if (query.length > 2) {
                // Simple client-side search highlighting
                highlightSearchResults(query);
            } else {
                clearSearchHighlights();
            }
        });
        
        // Clear search on escape
        searchInput.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                this.value = '';
                this.blur();
                clearSearchHighlights();
            }
        });
    }
    
    function highlightSearchResults(query) {
        const documentCards = document.querySelectorAll('.document-card');
        documentCards.forEach(card => {
            const title = card.querySelector('.document-title a');
            const instructor = card.querySelector('.instructor-name, .depositor-name');
            const courseCode = card.querySelector('.course-code-overlay, .file-type-overlay');
            
            let hasMatch = false;
            
            [title, instructor, courseCode].forEach(element => {
                if (element && element.textContent.toLowerCase().includes(query)) {
                    hasMatch = true;
                }
            });
            
            card.style.opacity = hasMatch ? '1' : '0.3';
        });
    }
    
    function clearSearchHighlights() {
        const documentCards = document.querySelectorAll('.document-card');
        documentCards.forEach(card => {
            card.style.opacity = '1';
        });
    }
}

function initializePagination() {
    const itemsPerPageSelect = document.getElementById('itemsPerPage');
    const paginationBtns = document.querySelectorAll('.pagination-btn');
    const paginationNumbers = document.querySelectorAll('.pagination-number');
    
    itemsPerPageSelect?.addEventListener('change', function() {
        const itemsPerPage = parseInt(this.value);
        updatePagination(1, itemsPerPage);
        console.log('Items per page changed to:', itemsPerPage);
    });
    
    paginationBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            if (this.classList.contains('prev-btn')) {
                // Handle previous page
                console.log('Previous page clicked');
            } else if (this.classList.contains('next-btn')) {
                // Handle next page
                console.log('Next page clicked');
            }
        });
    });
    
    paginationNumbers.forEach(btn => {
        btn.addEventListener('click', function() {
            const pageNumber = parseInt(this.textContent);
            updatePagination(pageNumber);
            console.log('Page', pageNumber, 'clicked');
        });
    });
    
    function updatePagination(page, itemsPerPage = 20) {
        // Update active page number
        paginationNumbers.forEach(btn => {
            btn.classList.remove('active');
            if (parseInt(btn.textContent) === page) {
                btn.classList.add('active');
            }
        });
        
        // This would typically involve server-side pagination
        // For now, just update the UI state
        showLoadingState();
        setTimeout(() => {
            hideLoadingState();
        }, 500);
    }
}

function initializePreview() {
    const previewBtns = document.querySelectorAll('.preview-btn');
    const modal = document.getElementById('documentPreviewModal');
    const modalFrame = document.getElementById('documentPreviewFrame');
    const modalDownloadBtn = document.getElementById('modalDownloadBtn');
    const closeBtns = document.querySelectorAll('#modalCloseBtn, #modalCloseFooterBtn, #modalBackdrop');
    
    previewBtns.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const url = this.dataset.url;
            if (url && modal && modalFrame) {
                modalFrame.src = url;
                if (modalDownloadBtn) {
                    modalDownloadBtn.href = url;
                }
                modal.classList.add('active');
                document.body.style.overflow = 'hidden';
                
                // Add loading state to modal
                modalFrame.style.opacity = '0.5';
                modalFrame.onload = function() {
                    this.style.opacity = '1';
                };
            }
        });
    });
    
    closeBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            if (modal) {
                modal.classList.remove('active');
                document.body.style.overflow = '';
                if (modalFrame) {
                    modalFrame.src = '';
                }
            }
        });
    });
    
    // Close modal on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && modal && modal.classList.contains('active')) {
            modal.classList.remove('active');
            document.body.style.overflow = '';
            if (modalFrame) {
                modalFrame.src = '';
            }
        }
    });
}

// Mobile filter toggle
function initializeMobileFilters() {
    const mobileFilterBtn = document.getElementById('mobileFilterBtn');
    const sidebar = document.querySelector('.portfolio-sidebar');
    const mobileFilterToggle = document.querySelector('.mobile-filter-toggle');
    
    mobileFilterBtn?.addEventListener('click', function() {
        if (sidebar) {
            sidebar.classList.toggle('mobile-active');
            document.body.style.overflow = sidebar.classList.contains('mobile-active') ? 'hidden' : '';
        }
    });
    
    mobileFilterToggle?.addEventListener('click', function() {
        if (sidebar) {
            sidebar.classList.remove('mobile-active');
            document.body.style.overflow = '';
        }
    });
}

// Filter expand/collapse
function initializeFilterExpansion() {
    document.querySelectorAll('.filter-expand').forEach(btn => {
        btn.addEventListener('click', function() {
            const target = this.dataset.target;
            const content = document.getElementById(target);
            const icon = this.querySelector('i');
            
            if (content && icon) {
                content.classList.toggle('collapsed');
                icon.classList.toggle('fa-chevron-down');
                icon.classList.toggle('fa-chevron-up');
                
                // Add smooth transition
                if (content.classList.contains('collapsed')) {
                    content.style.maxHeight = '0';
                    content.style.overflow = 'hidden';
                } else {
                    content.style.maxHeight = '300px';
                    content.style.overflow = 'auto';
                }
            }
        });
    });
}

// Utility functions
function showLoadingState() {
    const loadingState = document.getElementById('loadingState');
    if (loadingState) {
        loadingState.style.display = 'flex';
    }
}

function hideLoadingState() {
    const loadingState = document.getElementById('loadingState');
    if (loadingState) {
        loadingState.style.display = 'none';
    }
}

// Advanced sorting functionality
function initializeAdvancedSorting() {
    const sortSelect = document.getElementById('sortSelect');
    
    sortSelect?.addEventListener('change', function() {
        const sortBy = this.value;
        const documentCards = Array.from(document.querySelectorAll('.document-card'));
        const container = document.querySelector('.document-grid');
        
        if (!container) return;
        
        showLoadingState();
        
        setTimeout(() => {
            const sortedCards = documentCards.sort((a, b) => {
                switch (sortBy) {
                    case 'newest':
                        return new Date(b.dataset.date || 0) - new Date(a.dataset.date || 0);
                    case 'oldest':
                        return new Date(a.dataset.date || 0) - new Date(b.dataset.date || 0);
                    case 'title':
                        const titleA = a.querySelector('.document-title a')?.textContent || '';
                        const titleB = b.querySelector('.document-title a')?.textContent || '';
                        return titleA.localeCompare(titleB);
                    case 'course':
                        const courseA = a.querySelector('.course-code-overlay')?.textContent || '';
                        const courseB = b.querySelector('.course-code-overlay')?.textContent || '';
                        return courseA.localeCompare(courseB);
                    case 'instructor':
                        const instructorA = a.querySelector('.instructor-name, .depositor-name')?.textContent || '';
                        const instructorB = b.querySelector('.instructor-name, .depositor-name')?.textContent || '';
                        return instructorA.localeCompare(instructorB);
                    default:
                        return 0;
                }
            });
            
            // Re-append sorted cards
            sortedCards.forEach(card => container.appendChild(card));
            
            hideLoadingState();
        }, 300);
    });
}

// Initialize all mobile functionality
document.addEventListener('DOMContentLoaded', function() {
    initializeMobileFilters();
    initializeFilterExpansion();
    initializeAdvancedSorting();
});

// Intersection Observer for animation on scroll
function initializeScrollAnimations() {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    });
    
    document.querySelectorAll('.document-card').forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(card);
    });
}

// Initialize scroll animations after DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    setTimeout(initializeScrollAnimations, 100);
});
