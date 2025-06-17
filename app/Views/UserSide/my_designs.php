<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url('assets/css/UserSide/myDesign.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/UserSide/userPurchase.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/UserSide/grid.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/navbar.css') ?>">
    <link rel="shortcut icon" href="<?= base_url('assets/img/logo.png') ?>" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>My Design</title>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/three/examples/js/controls/OrbitControls.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/three/examples/js/loaders/GLTFLoader.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

    <style>
        /* Remove custom modal styles that might conflict with Bootstrap */
        /* .modal {
            display: none;
            position: fixed;
            z-index: 1050;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            background-color: rgba(0, 0, 0, 0.4);
        } */

        .modal-dialog {
            z-index: 1051;
            max-width: 600px;
        }
        
        .modal-content {
            margin: 5% auto;
            width: 100% !important;
            background: white;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            border: none;
        }

        .modal-header {
            background-color: #007bff;
            color: white;
            padding: 15px 20px;
            border-bottom: 1px solid #ddd;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
            position: relative;
        }

        .modal-header .close {
            color: white;
            font-size: 24px;
            border: none;
            background: none;
            position: absolute;
            top: 50%;
            right: 15px;
            transform: translateY(-50%);
            opacity: 0.8;
            transition: opacity 0.2s;
        }
        
        .modal-header .close:hover {
            opacity: 1;
        }

        .modal-body {
            padding: 25px;
        }
        
        .modal-body h4 {
            color: #333;
            margin-bottom: 15px;
            font-weight: 600;
            font-size: 18px;
            border-bottom: 1px solid #eee;
            padding-bottom: 8px;
        }

        .modal-body input,
        .modal-body textarea {
            width: 100%;
            padding: 10px 12px;
            margin-top: 5px;
            border: 1px solid #ddd;
            border-radius: 5px;
            transition: border-color 0.2s;
        }
        
        .modal-body input:focus,
        .modal-body textarea:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
            outline: none;
        }
        
        .modal-body textarea {
            resize: vertical;
            min-height: 80px;
        }
        
        .input-group-text {
            background-color: #f8f9fa;
            border-color: #ddd;
        }
        
        .order-summary {
            background-color: #f8f9fa;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 20px;
        }
        
        .order-summary h4 {
            margin-top: 0;
            color: #333;
            font-size: 18px;
            font-weight: 600;
        }
        
        .order-summary .card {
            border: 1px solid #eee;
            box-shadow: none;
        }
        
        .order-summary .card-body {
            padding: 15px;
        }
        
        .payment-method-section .card {
            border: 1px solid #eee;
            box-shadow: none;
        }
        
        .payment-icons {
            margin-top: 10px;
            color: #6c757d;
        }
        
        .form-check-input {
            margin-top: 0.3rem;
        }
        
        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
            padding: 10px 20px;
            font-weight: 600;
            transition: all 0.2s;
        }
        
        .btn-success:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }
        
        .btn-outline-secondary {
            color: #6c757d;
            border-color: #6c757d;
            padding: 10px 20px;
            font-weight: 600;
            transition: all 0.2s;
        }
        
        .btn-outline-secondary:hover {
            background-color: #6c757d;
            border-color: #6c757d;
            color: white;
        }
        
        /* Processing overlay */
        .processing-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.8);
            z-index: 2000;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        .processing-content {
            text-align: center;
            padding: 30px;
        }
        
        .success-checkmark {
            color: #28a745;
            margin-bottom: 15px;
        }
        
        /* Responsive adjustments */
        @media (max-width: 992px) {
            .modal-content {
                margin: 10% auto;
                width: 95% !important;
            }
            
            .modal-dialog {
                max-width: 95%;
                margin: 10px auto;
            }
            
            .form-row .form-group {
                margin-bottom: 15px;
            }
        }
        
        /* Alert styling */
        .alert {
            margin-bottom: 20px;
            border-radius: 5px;
        }
        
        .alert-danger {
            background-color: #f8d7da;
            border-color: #f5c6cb;
            color: #721c24;
        }
        
        .alert-success {
            background-color: #d4edda;
            border-color: #c3e6cb;
            color: #155724;
        }
        
        /* Loading spinner */
        .spinner-border {
            display: inline-block;
            width: 1.5rem;
            height: 1.5rem;
            vertical-align: text-bottom;
            border: 0.2em solid currentColor;
            border-right-color: transparent;
            border-radius: 50%;
            animation: spinner-border .75s linear infinite;
        }
        
        @keyframes spinner-border {
            to { transform: rotate(360deg); }
        }
        
        .d-none {
            display: none !important;
        }
        
        .spinner-border-sm {
            width: 1rem;
            height: 1rem;
            border-width: 0.2em;
        }
    </style>
</head>

<body>
    <?php echo view("includes/header.php"); ?>

    <div class="mydesign user-main-content">
        <?php echo view(name: "UserSide/sideNav"); ?>

        <div class="user-content">
            <h2>My Custom Designs</h2>
        
            <div class="design-container">
                <?php if (!empty($designs)): ?>
                    <?php foreach ($designs as $design): ?>
                        <div class="design-card">
                            <div id="canvas-container-<?= $design['id'] ?>" class="canvas-container"></div>
        
                            <div class="design-details">
                                <!--    <h3>Design #<?= $design['id'] ?></h3> -->
                                <p><span class="spec-label">Design Name:</span> <?= htmlspecialchars($design['design_name'] ?? 'Unnamed Design') ?></p>
                                <p><span class="spec-label">Material:</span> <?= ucfirst($design['material']) ?></p>
                                <p><span class="spec-label">Size:</span> <?= ucfirst($design['size']) ?></p>
                                <p><span class="spec-label">Category:</span> <?= ucfirst($design['category']) ?></p>
                                <p><strong>Price:</strong> ₱<?= number_format($design['price'], 2) ?></p>
        
                                <button class="delete-btn" onclick="deleteDesign(<?= $design['id'] ?>)">Delete</button>
                                <button class="checkout-btn" onclick="openCheckoutModal(<?= $design['id'] ?>, <?= $design['price'] ?>)">Checkout</button>
        
                                <h4>Specifications:</h4>
                                <p><span class="spec-label">Driver Configuration:</span></p>
                                <ul id="driverConfig-<?= $design['id'] ?>" class="spec-list"></ul>
        
                                <p><span class="spec-label">Sound Signature:</span></p>
                                <ul id="soundSignature-<?= $design['id'] ?>" class="spec-list"></ul>
        
                                <p><span class="spec-label">Frequency Response:</span>
                                    <span id="frequencyResponse-<?= $design['id'] ?>"></span>
                                </p>
        
                                <p><span class="spec-label">Technical Specs:</span></p>
                                <ul id="technicalSpecs-<?= $design['id'] ?>" class="spec-list"></ul>
                            </div>
                        </div>
        
                        <div id="checkoutModal-<?= $design['id'] ?>" class="modal fade" tabindex="-1" role="dialog">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h3 class="modal-title">Confirm Your Order</h3>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="order-summary mb-4">
                                            <h4>Order Summary</h4>
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between">
                                                        <span>Design:</span>
                                                        <span id="summaryDesignName"></span>
                                                    </div>
                                                    <div class="d-flex justify-content-between">
                                                        <span>Category:</span>
                                                        <span id="summaryCategory"></span>
                                                    </div>
                                                    <div class="d-flex justify-content-between font-weight-bold mt-2">
                                                        <span>Total:</span>
                                                        <span id="summaryPrice"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <form id="checkoutForm">
                                            <input type="hidden" id="designId" name="design_id">
                                            <input type="hidden" id="designPrice" name="price">
                                            
                                            <h4>Shipping Information</h4>
                                            <p class="text-muted">Your order will be shipped to the address in your profile.</p>
                                            
                                            <div class="user-profile-info card mb-4">
                                                <div class="card-body">
                                                    <div class="form-group">
                                                        <label>Full Name</label>
                                                        <input type="text" id="fullname" name="fullname" class="form-control" readonly>
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <label>Phone Number</label>
                                                        <input type="text" id="phone" name="phone" class="form-control" readonly>
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <label>Complete Address</label>
                                                        <textarea id="address" name="address" class="form-control" rows="2" readonly></textarea>
                                                    </div>
                                                    
                                                    <div class="form-group row mb-0">
                                                        <div class="col-md-6">
                                                            <label>City/Municipality</label>
                                                            <input type="text" id="cityMunicipality" class="form-control" readonly>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label>Country</label>
                                                            <input type="text" id="country" class="form-control" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="alert alert-info">
                                                <i class="fas fa-info-circle mr-2"></i>
                                                You'll be redirected to our secure payment gateway after confirming your order.
                                            </div>
        
                                            <div class="text-center">
                                                <button type="button" class="btn btn-outline-secondary mr-2" data-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-success">
                                                    <span id="btnText">Confirm Order</span>
                                                    <span id="loader" class="spinner-border spinner-border-sm d-none"></span>
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
        
                        <script>
                            document.addEventListener("DOMContentLoaded", function() {
                                const gearSpecs = {
                                    "Vanilla Series": {
                                        driverConfig: [
                                            "Balanced Armature Drivers per side",
                                            "1 x Custom 9.2mm LSR Dynamic Driver – Delivers deep, punchy bass with natural warmth.",
                                            "1 x Knowles Balanced Armature Driver – Enhances clarity in mids and highs for a smooth, detailed sound.",
                                            "2-Way Crossover – Ensures a seamless transition between bass and mids/highs for a well-balanced sound signature."
                                        ],
                                        soundSignature: [
                                            "Balanced and natural tuning, suitable for a variety of genres",
                                            "Mild bass boost, keeping the low end warm yet controlled",
                                            "Clear mids, allowing vocals and instruments to shine",
                                            "Smooth highs, preventing harshness for extended listening comfort"
                                        ],
                                        frequencyResponse: "20Hz – 18kHz, tuned for a fun yet natural listening experience",
                                        technicalSpecs: [
                                            "Frequency Response: 20Hz – 20kHz",
                                            "Sensitivity: 105dB @ 100mV @ 1kHz",
                                            "Impedance: 16Ω @ 1kHz"
                                        ]
                                    },
                                    "Stage Series": {
                                        driverConfig: [
                                            "3-Driver Hybrid System",
                                            "1 × Custom 9.2mm LSR Dynamic Driver – Produces powerful and controlled bass, ideal for live monitoring.",
                                            "1 × Knowles Balanced Armature for Mids – Ensures clear and natural midrange for instruments and vocals.",
                                            "1 × Sonion Balanced Armature for Highs – Provides extended treble for a crisp and detailed listening experience.",
                                            "3-Way Crossover – Separates lows, mids, and highs efficiently for precision in live performance scenarios."
                                        ],
                                        soundSignature: [
                                            "Enhanced bass for live-stage impact",
                                            "Crisp and clear vocals for maximum performance clarity",
                                            "Highs tuned to prevent fatigue during long sessions"
                                        ],
                                        frequencyResponse: "15Hz – 30kHz, ideal for stage performers and audiophiles",
                                        technicalSpecs: [
                                            "Frequency Response: 15Hz – 30kHz",
                                            "Sensitivity: 102dB @ 1kHz",
                                            "Impedance: 12Ω @ 1kHz"
                                        ]
                                    },
                                    'Prestige Series': {
                                        driverConfig: [
                                            '5-Driver Tribrid Design',
                                            '1 x Custom 9.2mm LSR Dynamic Driver – Dedicated for powerful and controlled low frequencies.',
                                            '1 × Knowles ED-30000 Balanced Armature – Enhancing low-mid transitions for natural warmth.',
                                            '1 × Sonion 2300 Balanced Armature – Optimized for smooth and detailed mid-high frequencies.',
                                            '2 × New Generation Sonion Electrostatic Drivers – Delivering exceptional high-frequency extension and airiness.',
                                            '4-Way Crossover – Ensures precise frequency separation for a balanced and immersive sound.'
                                        ],
                                        soundSignature: [
                                            'Enhanced bass for live-stage impact',
                                            'Crisp and clear vocals for maximum performance clarity',
                                            'Highs tuned to prevent fatigue during long sessions'
                                        ],
                                        frequencyResponse: '15Hz – 30kHz, ideal for stage performers and audiophiles',
                                        technicalSpecs: [
                                            'Frequency Response: 20Hz – 40kHz',
                                            'Sensitivity: 970dB @ 1kHz',
                                            'Impedance: 10Ω @ 1kHz'
                                        ]
                                    }
                                };
        
                                function populateSpecs(designId, category) {
                                    if (gearSpecs[category]) {
                                        const specs = gearSpecs[category];
        
                                        function populateList(elementId, items) {
                                            const element = document.getElementById(elementId);
                                            if (element) {
                                                element.innerHTML = "";
                                                items.forEach(item => {
                                                    const li = document.createElement("li");
                                                    li.textContent = item;
                                                    element.appendChild(li);
                                                });
                                            }
                                        }
        
                                        populateList(`driverConfig-${designId}`, specs.driverConfig);
                                        populateList(`soundSignature-${designId}`, specs.soundSignature);
                                        document.getElementById(`frequencyResponse-${designId}`).textContent = specs.frequencyResponse;
                                        populateList(`technicalSpecs-${designId}`, specs.technicalSpecs);
                                    }
                                }
        
                                <?php foreach ($designs as $design): ?>
                                    populateSpecs("<?= $design['id'] ?>", "<?= $design['category'] ?>");
                                <?php endforeach; ?>
                            });
                        </script>
                        <script>
                            function openCheckoutModal(designId, price) {
                                console.log('Opening checkout modal for design ID:', designId, 'price:', price);
                                
                                const designCard = document.querySelector(`.design-card:has(#canvas-container-${designId})`);
                                let designName = 'Custom IEM';
                                let category = '';
                                
                                if (designCard) {
                                    const designNameEl = designCard.querySelector('.design-details p:nth-child(1) .spec-label + span');
                                    const categoryEl = designCard.querySelector('.design-details p:nth-child(4) .spec-label + span');
                                    
                                    if (designNameEl) {
                                        designName = designNameEl.textContent.trim() || designCard.querySelector('.design-details p:nth-child(1)').textContent.replace('Design Name:', '').trim();
                                    }
                                    
                                    if (categoryEl) {
                                        category = categoryEl.textContent.trim() || designCard.querySelector('.design-details p:nth-child(4)').textContent.replace('Category:', '').trim();
                                    }
                                }
                                
                                const modalId = `checkoutModal-${designId}`;
                                const modal = document.getElementById(modalId);
                                
                                if (!modal) {
                                    console.error(`Modal with ID ${modalId} not found`);
                                    return;
                                }
                                
                                const designIdInput = modal.querySelector('#designId');
                                const designPriceInput = modal.querySelector('#designPrice');
                                const summaryDesignName = modal.querySelector('#summaryDesignName');
                                const summaryCategory = modal.querySelector('#summaryCategory');
                                const summaryPrice = modal.querySelector('#summaryPrice');
                                
                                if (designIdInput) designIdInput.value = designId;
                                if (designPriceInput) designPriceInput.value = price;
                                
                                // Update the order summary
                                if (summaryDesignName) summaryDesignName.textContent = designName;
                                if (summaryCategory) summaryCategory.textContent = category;
                                if (summaryPrice) summaryPrice.textContent = `₱${parseFloat(price).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}`;
                                
                                // Get user profile details from PHP
                                const userData = <?= json_encode($userData ?? []) ?>;
                                console.log('User data from PHP:', userData);
                                
                                // Extract user information
                                const firstname = userData.firstname || '';
                                const lastname = userData.lastname || '';
                                const fullname = firstname && lastname ? `${firstname} ${lastname}` : '';
                                const phone = userData.phone_number || '';
                                const address = userData.address || '';
                                const cityMunicipality = userData.city_municipality || '';
                                const country = userData.country || '';
                                const zipcode = userData.zipcode || '';
                                
                                // Create a complete address
                                let completeAddress = address;
                                if (cityMunicipality) completeAddress += completeAddress ? `, ${cityMunicipality}` : cityMunicipality;
                                if (zipcode) completeAddress += completeAddress ? `, ${zipcode}` : zipcode;
                                if (country) completeAddress += completeAddress ? `, ${country}` : country;
                                
                                // Display user information in the form
                                const fullnameInput = modal.querySelector('#fullname');
                                const phoneInput = modal.querySelector('#phone');
                                const addressInput = modal.querySelector('#address');
                                const cityMunicipalityInput = modal.querySelector('#cityMunicipality');
                                const countryInput = modal.querySelector('#country');
                                
                                if (fullnameInput) fullnameInput.value = fullname || 'Not set in profile';
                                if (phoneInput) phoneInput.value = phone || 'Not set in profile';
                                if (addressInput) addressInput.value = completeAddress || 'Not set in profile';
                                if (cityMunicipalityInput) cityMunicipalityInput.value = cityMunicipality || 'Not set in profile';
                                if (countryInput) countryInput.value = country || 'Not set in profile';
                                
                                // Show the modal
                                $(`#${modalId}`).modal('show');
                                
                                // ALWAYS enable the submit button
                                const submitButton = modal.querySelector('button[type="submit"]');
                                if (submitButton) {
                                    submitButton.disabled = false;
                                    console.log('Submit button enabled');
                                }
                                
                                // Show warning if profile is incomplete but still allow checkout
                                if (!firstname || !lastname || !phone || !address) {
                                    console.log('Profile incomplete, showing warning');
                                    const warningDiv = document.createElement('div');
                                    warningDiv.className = 'alert alert-warning';
                                    warningDiv.innerHTML = `
                                        <i class="fas fa-exclamation-triangle mr-2"></i>
                                        <strong>Note:</strong> Some profile information is missing. You can still proceed, but we recommend updating your profile for future orders.
                                    `;
                                    
                                    const modalBody = modal.querySelector('.modal-body');
                                    if (modalBody) {
                                        // Remove any existing warnings
                                        const existingWarnings = modalBody.querySelectorAll('.alert-warning');
                                        existingWarnings.forEach(warning => warning.remove());
                                        
                                        // Add the new warning
                                        modalBody.insertBefore(warningDiv, modalBody.firstChild);
                                    }
                                }
                            }
        
                            // Add event listeners to all checkout forms
                            document.querySelectorAll('[id^="checkoutModal-"]').forEach(modal => {
                                const form = modal.querySelector('#checkoutForm');
                                if (form) form.addEventListener('submit', function(event) {
                                event.preventDefault();
                                console.log('Form submitted');
                                
                                // Show loading state
                                const submitBtn = this.querySelector('button[type="submit"]');
                                const btnText = document.getElementById('btnText');
                                const loader = document.getElementById('loader');
                                
                                submitBtn.disabled = true;
                                btnText.textContent = 'Processing...';
                                loader.classList.remove('d-none');
                                
                                // Get form data
                                const formData = new FormData(this);
                                
                                // Log form data for debugging
                                console.log('Form data:');
                                for (let pair of formData.entries()) {
                                    console.log(pair[0] + ': ' + pair[1]);
                                }
                                
                                // Create a full-screen processing overlay
                                const overlay = document.createElement('div');
                                overlay.style.position = 'fixed';
                                overlay.style.top = '0';
                                overlay.style.left = '0';
                                overlay.style.width = '100%';
                                overlay.style.height = '100%';
                                overlay.style.backgroundColor = 'rgba(0, 0, 0, 0.7)';
                                overlay.style.display = 'flex';
                                overlay.style.justifyContent = 'center';
                                overlay.style.alignItems = 'center';
                                overlay.style.zIndex = '9999';
                                
                                const spinnerContainer = document.createElement('div');
                                spinnerContainer.style.textAlign = 'center';
                                spinnerContainer.style.color = 'white';
                                
                                const spinner = document.createElement('div');
                                spinner.className = 'spinner-border text-light';
                                spinner.style.width = '3rem';
                                spinner.style.height = '3rem';
                                spinner.setAttribute('role', 'status');
                                
                                const loadingText = document.createElement('h4');
                                loadingText.className = 'mt-3';
                                loadingText.textContent = 'Processing your order...';
                                
                                spinnerContainer.appendChild(spinner);
                                spinnerContainer.appendChild(loadingText);
                                overlay.appendChild(spinnerContainer);
                                document.body.appendChild(overlay);
                                
                                // Submit the form via AJAX
                                fetch('<?= base_url('customization/checkout') ?>', {
                                    method: 'POST',
                                    body: formData
                                })
                                .then(response => response.json())
                                .then(data => {
                                    console.log('Checkout response:', data);
                                    
                                    if (data.status === 'success') {
                                        // Success animation
                                        loadingText.textContent = 'Success! Redirecting to payment...';
                                        
                                        // Make sure we have a redirect URL
                                        if (!data.redirect_url) {
                                            console.error('No redirect URL provided');
                                            document.body.removeChild(overlay);
                                            
                                            const errorAlert = document.createElement('div');
                                            errorAlert.className = 'alert alert-danger alert-dismissible fade show';
                                            errorAlert.innerHTML = `
                                                <strong>Error:</strong> No payment URL provided. Please try again.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            `;
                                            
                                            document.querySelector('#checkoutModal .modal-body').prepend(errorAlert);
                                            
                                            // Reset button
                                            submitBtn.disabled = false;
                                            btnText.textContent = 'Confirm Order';
                                            loader.classList.add('d-none');
                                            return;
                                        }
                                        
                                        // Redirect to payment page after a short delay
                                        setTimeout(() => {
                                            console.log('Redirecting to:', data.redirect_url);
                                            window.location.href = data.redirect_url;
                                        }, 1500);
                                    } else {
                                        // Remove overlay
                                        document.body.removeChild(overlay);
                                        
                                        // Show error
                                        const errorAlert = document.createElement('div');
                                        errorAlert.className = 'alert alert-danger alert-dismissible fade show';
                                        errorAlert.innerHTML = `
                                            <strong>Error:</strong> ${data.message || 'An error occurred during checkout.'}
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        `;
                                        
                                        document.querySelector('#checkoutModal .modal-body').prepend(errorAlert);
                                        
                                        // Reset button
                                        submitBtn.disabled = false;
                                        btnText.textContent = 'Confirm Order';
                                        loader.classList.add('d-none');
                                    }
                                })
                                .catch(error => {
                                    // Remove overlay
                                    document.body.removeChild(overlay);
                                    
                                    // Show error
                                    const errorAlert = document.createElement('div');
                                    errorAlert.className = 'alert alert-danger alert-dismissible fade show';
                                    errorAlert.innerHTML = `
                                        <strong>Error:</strong> An unexpected error occurred. Please try again.
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    `;
                                    
                                    document.querySelector('#checkoutModal .modal-body').prepend(errorAlert);
                                    
                                    // Reset button
                                    submitBtn.disabled = false;
                                    btnText.textContent = 'Confirm Order';
                                    loader.classList.add('d-none');
                                    
                                    console.error('Checkout error:', error);
                                });
                            });
                            });
        
                            // This event handler is no longer needed as we're using the onclick attribute directly
                        </script>
                        <script>
                            function deleteDesign(designId) {
                                if (!confirm("Are you sure you want to delete this design?")) {
                                    return;
                                }
        
                                fetch('<?= base_url("customization/delete") ?>/' + designId, {
                                        method: 'DELETE'
                                    })
                                    .then(response => response.json())
                                    .then(data => {
                                        if (data.status === 'success') {
                                            alert("Design deleted successfully.");
                                            document.getElementById("canvas-container-" + designId).closest(".design-card").remove();
                                        } else {
                                            alert("Failed to delete design: " + data.message);
                                        }
                                    })
                                    .catch(error => {
                                        console.error("Error:", error);
                                        alert("An error occurred while deleting the design.");
                                    });
                            }
                        </script>
                        <script>
                            document.addEventListener("DOMContentLoaded", function() {
                                <?php foreach ($designs as $design): ?>
                                    (function() {
                                        const container = document.getElementById("canvas-container-<?= $design['id'] ?>");
    
                                        container.innerHTML = "";
    
                                        const scene = new THREE.Scene();
                                        const camera = new THREE.PerspectiveCamera(45, container.clientWidth / container.clientHeight, 0.1, 1000);
                                        const renderer = new THREE.WebGLRenderer({
                                            antialias: true,
                                            alpha: true
                                        });
    
                                        renderer.setSize(container.clientWidth, container.clientHeight);
                                        renderer.setPixelRatio(window.devicePixelRatio);
                                        container.appendChild(renderer.domElement);
    
                                        const controls = new THREE.OrbitControls(camera, renderer.domElement);
                                        controls.enableDamping = true;
                                        controls.dampingFactor = 0.1;
                                        controls.autoRotate = false;
                                        controls.autoRotateSpeed = 2.0;
                                        controls.minDistance = 1;
                                        controls.maxDistance = 5;
    
                                        const ambientLight = new THREE.AmbientLight(0xffffff, 1.5);
                                        scene.add(ambientLight);
    
                                        const directionalLight = new THREE.DirectionalLight(0xffffff, 3);
                                        directionalLight.position.set(3, 3, 5);
                                        scene.add(directionalLight);
    
                                        const loader = new THREE.GLTFLoader();
                                        const loadingText = document.createElement("p");
                                        loadingText.innerText = "Loading IEM Model...";
                                        loadingText.style.color = "white";
                                        loadingText.style.textAlign = "center";
                                        loadingText.style.marginTop = "20px";
                                        container.appendChild(loadingText);
                                        
                                        loader.load("<?= base_url('assets/models/origiem.glb') ?>", function(gltf) {
                                            container.removeChild(loadingText);
                                            const iemModel = gltf.scene;
                                            
                                            let leftShell, rightShell, leftFaceplate, rightFaceplate;
                                            
                                            iemModel.traverse((child) => {
                                                if (child.isMesh) {
                                                    const material = new THREE.MeshPhysicalMaterial({
                                                        color: 0xf2e6d8,
                                                        clearcoat: 0.5,
                                                        clearcoatRoughness: 0.2,
                                                        envMapIntensity: 1.0,
                                                        side: THREE.DoubleSide,
                                                        transparent: false,
                                                        depthWrite: true,
                                                        depthTest: true
                                                    });
                                                    
                                                    child.material = material;
                                                    child.castShadow = true;
                                                    child.receiveShadow = true;
                                                    
                                                    if (child.name.toLowerCase().includes("leftshell") || (!leftShell && child.position.x < -0.1)) {
                                                        leftShell = child;
                                                        leftShell.material.name = "leftShell";
                                                        leftShell.material.color.set("<?= $design['left_color'] ?>");
                                                    } else if (child.name.toLowerCase().includes("rightshell") || (!rightShell && child.position.x > 0.1)) {
                                                        rightShell = child;
                                                        rightShell.material.name = "rightShell";
                                                        rightShell.material.color.set("<?= $design['right_color'] ?? $design['left_color'] ?>");
                                                    } else if (child.name.toLowerCase().includes("leftfaceplate") || (!leftFaceplate && child.position.x < -0.05)) {
                                                        leftFaceplate = child;
                                                        leftFaceplate.material.name = "leftFaceplate";
                                                        leftFaceplate.material.color.set("<?= isset($design['left_faceplate_color']) ? $design['left_faceplate_color'] : $design['left_color'] ?>");
                                                    } else if (child.name.toLowerCase().includes("rightfaceplate") || (!rightFaceplate && child.position.x > 0.05)) {
                                                        rightFaceplate = child;
                                                        rightFaceplate.material.name = "rightFaceplate";
                                                        rightFaceplate.material.color.set("<?= isset($design['right_faceplate_color']) ? $design['right_faceplate_color'] : ($design['right_color'] ?? $design['left_color']) ?>");
                                                    }
                                                }
                                            });
                                            
                                            if (!leftShell || !rightShell || !leftFaceplate || !rightFaceplate) {
                                                const meshes = [];
                                                iemModel.traverse((child) => {
                                                    if (child.isMesh) meshes.push(child);
                                                });
                                                
                                                if (meshes.length >= 2) {
                                                    meshes.sort((a, b) => a.position.x - b.position.x);
                                                    leftShell = leftFaceplate = meshes[0];
                                                    rightShell = rightFaceplate = meshes[meshes.length - 1];
                                                    
                                                    if (leftShell) {
                                                        leftShell.material.color.set("<?= $design['left_color'] ?>");
                                                    }
                                                    if (rightShell) {
                                                        rightShell.material.color.set("<?= $design['right_color'] ?? $design['left_color'] ?>");
                                                    }
                                                }
                                            }
                                            
                                            const applyMaterialProperties = (part) => {
                                                if (!part) return;
                                                
                                                switch("<?= $design['material'] ?>") {
                                                    case 'glossy':
                                                        part.material.metalness = 0.2;
                                                        part.material.roughness = 0.1;
                                                        part.material.clearcoat = 0.8;
                                                        break;
                                                    case 'matte':
                                                        part.material.metalness = 0.1;
                                                        part.material.roughness = 0.8;
                                                        part.material.clearcoat = 0.1;
                                                        break;
                                                    case 'metallic':
                                                        part.material.metalness = 0.9;
                                                        part.material.roughness = 0.2;
                                                        part.material.clearcoat = 0.5;
                                                        break;
                                                    case 'ceramic':
                                                        part.material.metalness = 0.3;
                                                        part.material.roughness = 0.4;
                                                        part.material.clearcoat = 0.7;
                                                        break;
                                                    default:
                                                        part.material.metalness = 0.5;
                                                        part.material.roughness = 0.5;
                                                        part.material.clearcoat = 0.5;
                                                }
                                                part.material.needsUpdate = true;
                                            };
                                            applyMaterialProperties(leftShell);
                                            applyMaterialProperties(rightShell);
                                            applyMaterialProperties(leftFaceplate);
                                            applyMaterialProperties(rightFaceplate);
                                            
                                            const textureLoader = new THREE.TextureLoader();
                                            
                                            const applyTexture = (part, texturePath) => {
                                                if (!part || !texturePath) return;
                                                
                                                const texture = textureLoader.load(texturePath);
                                                texture.wrapS = THREE.RepeatWrapping;
                                                texture.wrapT = THREE.RepeatWrapping;
                                                part.material.map = texture;
                                                part.material.needsUpdate = true;
                                            };
                                           
                                            if ("<?= $design['left_texture'] ?>" && "<?= $design['left_texture'] ?>" !== "none") {
                                                if (leftShell) {
                                                    applyTexture(leftShell, "<?= base_url('assets/textures/') . $design['left_texture'] ?>");
                                                }
                                            }
                                            
                                            if (leftFaceplate) {
                                                <?php if(isset($design['left_faceplate_texture']) && $design['left_faceplate_texture'] && $design['left_faceplate_texture'] !== 'none'): ?>
                                                    applyTexture(leftFaceplate, "<?= base_url('assets/textures/') . $design['left_faceplate_texture'] ?>");
                                                <?php elseif($design['left_texture'] && $design['left_texture'] !== 'none'): ?>
                                                    applyTexture(leftFaceplate, "<?= base_url('assets/textures/') . $design['left_texture'] ?>");
                                                <?php endif; ?>
                                            }
                                            
                                            if ("<?= $design['right_texture'] ?>" && "<?= $design['right_texture'] ?>" !== "none") {
                                                if (rightShell) {
                                                    applyTexture(rightShell, "<?= base_url('assets/textures/') . $design['right_texture'] ?>");
                                                }
                                            }
                                            
                                            if (rightFaceplate) {
                                                <?php if(isset($design['right_faceplate_texture']) && $design['right_faceplate_texture'] && $design['right_faceplate_texture'] !== 'none'): ?>
                                                    applyTexture(rightFaceplate, "<?= base_url('assets/textures/') . $design['right_faceplate_texture'] ?>");
                                                <?php elseif($design['right_texture'] && $design['right_texture'] !== 'none'): ?>
                                                    applyTexture(rightFaceplate, "<?= base_url('assets/textures/') . $design['right_texture'] ?>");
                                                <?php endif; ?>
                                            }
                                            
                                            const turntable = new THREE.Group();
                                            turntable.add(iemModel);
                                            turntable.name = "turntable";
                                            scene.add(turntable);
    
                                            const box = new THREE.Box3().setFromObject(iemModel);
                                            const center = box.getCenter(new THREE.Vector3());
                                            iemModel.position.sub(center);
    
                                            const size = box.getSize(new THREE.Vector3()).length();
                                            const scaleFactor = 1.5 / size;
                                            iemModel.scale.set(scaleFactor, scaleFactor, scaleFactor);
    
                                            scene.add(iemModel);
                                            camera.position.set(0, 0, 3);
                                            camera.lookAt(0, 0, 0);
    
                                            function animate() {
                                                requestAnimationFrame(animate);
                                                controls.update();
                                                renderer.render(scene, camera);
                                            }
                                            animate();
                                        });
    
                                        function onWindowResize() {
                                            camera.aspect = container.clientWidth / container.clientHeight;
                                            camera.updateProjectionMatrix();
                                            renderer.setSize(container.clientWidth, container.clientHeight);
                                        }
                                        window.addEventListener("resize", onWindowResize);
                                    })();
                                <?php endforeach; ?>
                            });
                        </script>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No custom designs found.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <!-- Fixed script imports -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Simplified modal initialization -->
    <script>
        $(document).ready(function() {
            // Initialize modals when they're shown
            $('[id^="checkoutModal-"]').on('show.bs.modal', function() {
                const modal = $(this);
                const designId = modal.attr('id').replace('checkoutModal-', '');
                console.log('Modal opening for design ID:', designId);
                
                // Get design details
                const designCard = $(`.design-card:has(#canvas-container-${designId})`);
                const designName = designCard.find('.design-details p:nth-child(1)').text().replace('Design Name:', '').trim();
                const category = designCard.find('.design-details p:nth-child(4)').text().replace('Category:', '').trim();
                const price = designCard.find('.design-details p:nth-child(5)').text().replace('Price:', '').trim();
                
                // Update form fields
                modal.find('#designId').val(designId);
                modal.find('#designPrice').val(price.replace('₱', '').replace(',', ''));
                
                // Populate shipping information fields
                modal.find('#fullname').val('<?= $user_name ?>' || 'Not set in profile');
                modal.find('#phone').val('<?= $user_phone ?>' || 'Not set in profile');
                modal.find('#address').val('<?= $user_address ?>' || 'Not set in profile');
                modal.find('#cityMunicipality').val('<?= $user_city_municipality ?>' || 'Not set in profile');
                modal.find('#country').val('<?= $user_country ?>' || 'Not set in profile');
            
        }
    );
    });
    </script>
       