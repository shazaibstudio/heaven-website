// Heaven Hotel Website JavaScript

// Booking Modal Functions
function openBookingModal() {
    document.getElementById('bookingModal').style.display = 'block';
}

function closeBookingModal() {
    document.getElementById('bookingModal').style.display = 'none';
}

// Search Rooms Function
function searchRooms() {
    const checkin = document.getElementById('checkin').value;
    const checkout = document.getElementById('checkout').value;
    const guests = document.getElementById('guests').value;
    
    if (!checkin || !checkout) {
        alert('Please select check-in and check-out dates');
        return;
    }
    
    // Open booking modal with pre-filled data
    openBookingModal();
}

// Book Room Functions
function bookRoom(roomType) {
    openBookingModal();
    // Pre-select room type if modal has room selection
    const roomSelect = document.querySelector('#bookingModal select[required]');
    if (roomSelect) {
        roomSelect.value = roomType;
    }
}

function viewRoom(roomType) {
    // Could open a detailed room view or gallery
    alert(`Viewing ${roomType} details`);
}

// Smooth Scrolling for Navigation
document.addEventListener('DOMContentLoaded', function() {
    const navLinks = document.querySelectorAll('a[href^="#"]');
    
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('href');
            const targetSection = document.querySelector(targetId);
            
            if (targetSection) {
                targetSection.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
    
    // Set default dates for booking form
    const today = new Date();
    const tomorrow = new Date(today);
    tomorrow.setDate(tomorrow.getDate() + 1);
    
    const checkinInput = document.getElementById('checkin');
    const checkoutInput = document.getElementById('checkout');
    
    if (checkinInput) {
        checkinInput.value = today.toISOString().split('T')[0];
    }
    if (checkoutInput) {
        checkoutInput.value = tomorrow.toISOString().split('T')[0];
    }
});

// Close modal when clicking outside
window.addEventListener('click', function(event) {
    const modal = document.getElementById('bookingModal');
    if (event.target === modal) {
        closeBookingModal();
    }
});

// Mobile Menu Toggle
function toggleMobileMenu() {
    const navMenu = document.querySelector('.nav-menu');
    navMenu.classList.toggle('active');
}

// Form Submissions
document.addEventListener('DOMContentLoaded', function() {
    // Contact Form
    const contactForm = document.querySelector('.contact-form');
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Thank you for your message! We will contact you soon.');
            this.reset();
        });
    }
    
    // Booking Form
    const bookingForm = document.querySelector('.reservation-form');
    if (bookingForm) {
        bookingForm.addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Booking request submitted! We will confirm your reservation shortly.');
            closeBookingModal();
            this.reset();
        });
    }
});