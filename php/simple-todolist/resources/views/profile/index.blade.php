@extends('layouts.app')

@section('title', 'Profile Settings')

@section('content')
<style>
    .settings-container {
        max-width: 900px;
        margin: 0 auto;
    }

    .settings-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 2rem;
        border-radius: 0.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .settings-header h1 {
        margin: 0;
        font-size: 2rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .settings-header p {
        margin: 0.5rem 0 0;
        opacity: 0.9;
    }

    .settings-card {
        background: white;
        border-radius: 0.5rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        margin-bottom: 1.5rem;
        overflow: hidden;
    }

    .settings-card-header {
        background-color: #f9fafb;
        padding: 1.25rem 1.5rem;
        border-bottom: 2px solid #e5e7eb;
    }

    .settings-card-header h2 {
        margin: 0;
        font-size: 1.25rem;
        font-weight: 600;
        color: #111827;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .settings-card-body {
        padding: 1.5rem;
    }

    .avatar-section {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        flex-wrap: wrap;
    }

    .avatar-preview {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid #e5e7eb;
        background-color: #f3f4f6;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        color: #9ca3af;
        cursor: pointer;
        position: relative;
        overflow: hidden;
        transition: all 0.2s;
    }

    .avatar-preview:hover::after {
        content: 'View';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.7);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.875rem;
        font-weight: 600;
    }

    .avatar-preview img {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
    }

    .avatar-actions {
        flex: 1;
        min-width: 250px;
    }

    .avatar-buttons {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
        margin-bottom: 0.75rem;
    }

    .file-input-wrapper {
        position: relative;
        overflow: hidden;
        display: inline-block;
    }

    .file-input-wrapper input[type=file] {
        position: absolute;
        left: -9999px;
    }

    .btn-upload {
        background-color: #667eea;
        color: white;
        padding: 0.625rem 1.25rem;
        border-radius: 0.375rem;
        cursor: pointer;
        border: none;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.2s;
    }

    .btn-upload:hover {
        background-color: #5568d3;
    }

    .btn-remove {
        background-color: #ef4444;
        color: white;
        padding: 0.625rem 1.25rem;
        border-radius: 0.375rem;
        cursor: pointer;
        border: none;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.2s;
    }

    .btn-remove:hover {
        background-color: #dc2626;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        font-weight: 600;
        color: #374151;
        margin-bottom: 0.5rem;
        display: block;
        font-size: 0.875rem;
    }

    .form-control {
        border: 2px solid #e5e7eb;
        border-radius: 0.5rem;
        padding: 0.75rem 1rem;
        font-size: 0.95rem;
        transition: all 0.2s;
        width: 100%;
    }

    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        outline: none;
    }

    .form-control.is-invalid {
        border-color: #ef4444;
        background-image: none;
    }

    .invalid-feedback {
        color: #ef4444;
        font-size: 0.8rem;
        margin-top: 0.375rem;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 0.5rem;
        border: none;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
    }

    .danger-zone {
        border: 2px solid #fee2e2;
        background-color: #fef2f2;
        border-radius: 0.5rem;
        padding: 1.5rem;
    }

    .danger-zone h3 {
        color: #991b1b;
        font-size: 1.125rem;
        font-weight: 600;
        margin: 0 0 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .danger-zone p {
        color: #7f1d1d;
        margin: 0 0 1rem;
        font-size: 0.875rem;
    }

    .btn-danger {
        background-color: #ef4444;
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 0.5rem;
        border: none;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-danger:hover {
        background-color: #dc2626;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.4);
    }

    .input-group-custom {
        position: relative;
    }

    .password-toggle {
        position: absolute;
        right: 1rem;
        top: 0.9rem;
        background: none;
        border: none;
        color: #9ca3af;
        cursor: pointer;
        padding: 0.25rem;
        z-index: 2;
        font-size: 1.125rem;
        line-height: 1;
    }

    .password-toggle:hover {
        color: #667eea;
    }

    /* View Modal Styles */
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.9);
        animation: fadeIn 0.3s;
    }

    .modal.active {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem;
    }

    .modal-content-wrapper {
        max-width: 90%;
        max-height: 90%;
        position: relative;
    }

    .modal-content-wrapper img {
        max-width: 100%;
        max-height: 80vh;
        object-fit: contain;
        border-radius: 0.5rem;
    }

    .no-photo-message {
        background: white;
        padding: 3rem 4rem;
        border-radius: 0.5rem;
        text-align: center;
    }

    .no-photo-message i {
        font-size: 4rem;
        color: #9ca3af;
        margin-bottom: 1rem;
    }

    .no-photo-message h3 {
        color: #374151;
        margin: 0 0 0.5rem;
        font-size: 1.5rem;
    }

    .no-photo-message p {
        color: #6b7280;
        margin: 0;
    }

    .modal-close {
        position: absolute;
        top: -3rem;
        right: 0;
        color: white;
        font-size: 2.5rem;
        font-weight: bold;
        cursor: pointer;
        background: rgba(0, 0, 0, 0.5);
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
    }

    .modal-close:hover {
        background: rgba(239, 68, 68, 0.8);
        transform: scale(1.1);
    }

    /* Crop Modal Styles */
    .crop-modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.9);
    }

    .crop-modal.active {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem;
    }

    .crop-container {
        background: white;
        border-radius: 0.5rem;
        padding: 1.5rem;
        max-width: 800px;
        width: 100%;
    }

    .crop-container h3 {
        margin: 0 0 1rem;
        color: #111827;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 1.25rem;
    }

    .crop-image-container {
        max-height: 500px;
        margin-bottom: 1rem;
        border: 2px solid #e5e7eb;
        border-radius: 0.5rem;
        overflow: hidden;
    }

    .crop-image-container img {
        max-width: 100%;
        display: block;
    }

    .crop-controls {
        display: flex;
        gap: 1rem;
        margin-bottom: 1rem;
        flex-wrap: wrap;
        align-items: center;
    }

    .crop-control-group {
        display: flex;
        gap: 0.5rem;
        align-items: center;
    }

    .crop-control-btn {
        background-color: #f3f4f6;
        color: #374151;
        padding: 0.5rem 0.75rem;
        border-radius: 0.375rem;
        border: none;
        cursor: pointer;
        font-size: 0.875rem;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
    }

    .crop-control-btn:hover {
        background-color: #e5e7eb;
    }

    .crop-buttons {
        display: flex;
        gap: 0.5rem;
        justify-content: flex-end;
    }

    .btn-secondary {
        background-color: #6b7280;
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 0.5rem;
        border: none;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-secondary:hover {
        background-color: #4b5563;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @media (max-width: 768px) {
        .avatar-section {
            flex-direction: column;
            align-items: flex-start;
        }

        .avatar-preview {
            width: 100px;
            height: 100px;
            font-size: 2.5rem;
        }

        .modal-close {
            top: 1rem;
            right: 1rem;
            width: 40px;
            height: 40px;
            font-size: 2rem;
        }

        .no-photo-message {
            padding: 2rem;
        }

        .crop-controls {
            flex-direction: column;
            align-items: stretch;
        }

        .crop-control-group {
            justify-content: space-between;
        }
    }
</style>

<div class="settings-container">
    <div class="settings-header">
        <h1>
            <i class="bi bi-gear"></i>
            Profile Settings
        </h1>
        <p>Manage your account settings and preferences</p>
    </div>

    {{-- Profile Picture --}}
    <div class="settings-card">
        <div class="settings-card-header">
            <h2>
                <i class="bi bi-person-circle"></i>
                Profile Picture
            </h2>
        </div>
        <div class="settings-card-body">
            <form method="POST" action="{{ route('profile.avatar') }}" enctype="multipart/form-data" id="avatarForm">
                @csrf
                <div class="avatar-section">
                    <div class="avatar-preview" id="avatarPreview" onclick="viewAvatar()">
                        @if(auth()->user()->avatar)
                            <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="Avatar" id="currentAvatar">    <!-- look for public folder -->
                        @else
                            <i class="bi bi-person-circle"></i>
                        @endif
                    </div>
                    <div class="avatar-actions">
                        <p style="color: #6b7280; margin-bottom: 0.75rem; font-size: 0.875rem;">
                            <i class="bi bi-info-circle"></i> JPG, PNG or GIF. Max size 2MB. Drag to crop after upload.
                        </p>
                        <div class="avatar-buttons">
                            <div class="file-input-wrapper">
                                <label for="avatar" class="btn-upload">
                                    <i class="bi bi-upload"></i>
                                    Upload New Photo
                                </label>
                                <input type="file"
                                       id="avatar"
                                       name="avatar"
                                       accept="image/*"
                                       onchange="handleImageSelect(event)">     <!-- accept only image files/no validation -->
                            </div>
                            @if(auth()->user()->avatar)
                                <button type="submit" name="remove_avatar" value="1" class="btn-remove">
                                    <i class="bi bi-trash"></i>
                                    Remove Photo
                                </button>
                            @endif
                        </div>
                        @error('avatar')
                            <div class="invalid-feedback" style="display: flex;">
                                <i class="bi bi-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <input type="hidden" name="cropped_image" id="croppedImage">
                <div style="margin-top: 1rem;" id="saveButtonWrapper"></div>        <!-- save photo button -->
            </form>
        </div>
    </div>

    {{-- Personal Information --}}
    <div class="settings-card">
        <div class="settings-card-header">
            <h2>
                <i class="bi bi-person"></i>
                Personal Information
            </h2>
        </div>
        <div class="settings-card-body">
            <form method="POST" action="{{ route('profile.update') }}">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="name" class="form-label">Full Name</label>
                    <input type="text"
                           class="form-control @error('name') is-invalid @enderror"
                           id="name"
                           name="name"
                           value="{{ old('name', auth()->user()->name) }}">
                    @error('name')
                        <div class="invalid-feedback">
                            <i class="bi bi-exclamation-circle"></i> {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email"
                           class="form-control"
                           id="email"
                           value="{{ auth()->user()->email }}"
                           disabled>
                    <small style="color: #6b7280; font-size: 0.75rem; display: block; margin-top: 0.375rem;">
                        <i class="bi bi-info-circle"></i> Email cannot be changed
                    </small>
                </div>

                <button type="submit" class="btn-primary">
                    <i class="bi bi-check-circle"></i>
                    Update Information
                </button>
            </form>
        </div>
    </div>

    {{-- Change Password --}}
    <div class="settings-card">
        <div class="settings-card-header">
            <h2>
                <i class="bi bi-shield-lock"></i>
                Change Password
            </h2>
        </div>
        <div class="settings-card-body">
            <form method="POST" action="{{ route('profile.password') }}">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="current_password" class="form-label">Current Password</label>
                    <div class="input-group-custom">
                        <input type="password"
                               class="form-control @error('current_password') is-invalid @enderror"
                               id="current_password"
                               name="current_password"
                               placeholder="Enter current password">
                        <button type="button" class="password-toggle" onclick="togglePassword('current_password')">
                            <i class="bi bi-eye" id="current_password-icon"></i>
                        </button>
                        @error('current_password')
                            <div class="invalid-feedback">
                                <i class="bi bi-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">New Password</label>
                    <div class="input-group-custom">
                        <input type="password"
                               class="form-control @error('password') is-invalid @enderror"
                               id="password"
                               name="password"
                               placeholder="Minimum 8 characters">
                        <button type="button" class="password-toggle" onclick="togglePassword('password')">
                            <i class="bi bi-eye" id="password-icon"></i>
                        </button>
                        @error('password')
                            <div class="invalid-feedback">
                                <i class="bi bi-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="password_confirmation" class="form-label">Confirm New Password</label>
                    <div class="input-group-custom">
                        <input type="password"
                               class="form-control"
                               id="password_confirmation"
                               name="password_confirmation"
                               placeholder="Re-enter new password">
                        <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation')">
                            <i class="bi bi-eye" id="password_confirmation-icon"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn-primary">
                    <i class="bi bi-shield-check"></i>
                    Update Password
                </button>
            </form>
        </div>
    </div>

    {{-- Danger Zone --}}
    <div class="settings-card">
        <div class="settings-card-header">
            <h2>
                <i class="bi bi-exclamation-triangle"></i>
                Danger Zone
            </h2>
        </div>
        <div class="settings-card-body">
            <div class="danger-zone">
                <h3>
                    <i class="bi bi-trash"></i>
                    Delete Account
                </h3>
                <p>
                    Once you delete your account, there is no going back. This will permanently delete all your todos and data.
                </p>
                <form method="POST" action="{{ route('profile.destroy') }}" onsubmit="return confirm('Are you absolutely sure? This action cannot be undone. All your todos will be permanently deleted.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-danger">
                        <i class="bi bi-trash"></i>
                        Delete My Account
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- View Avatar Modal --}}
<div id="viewModal" class="modal" onclick="closeViewModal()">                   <!-- whole modal -->    <!-- close when click on area of modal -->
    <div class="modal-content-wrapper" onclick="event.stopPropagation()">       <!-- square modal -->
        <span class="modal-close" onclick="closeViewModal()">&times;</span>     <!-- close button -->   <!-- close when click on x button -->
        <div id="viewModalContent"></div>                                       <!-- modal content -->
    </div>
</div>

{{-- Crop Modal with Cropper.js --}}
<div id="cropModal" class="crop-modal">
    <div class="crop-container">
        <h3>
            <i class="bi bi-crop"></i>
            Crop Your Photo
        </h3>

        <div class="crop-image-container">
            <img id="cropImage" src="" alt="Image to crop">
        </div>

        <div class="crop-controls">
            <div class="crop-control-group">
                <button type="button" class="crop-control-btn" onclick="cropper.zoom(0.1)">
                    <i class="bi bi-zoom-in"></i> Zoom In
                </button>
                <button type="button" class="crop-control-btn" onclick="cropper.zoom(-0.1)">
                    <i class="bi bi-zoom-out"></i> Zoom Out
                </button>
            </div>
            <div class="crop-control-group">
                <button type="button" class="crop-control-btn" onclick="cropper.rotate(-90)">
                    <i class="bi bi-arrow-counterclockwise"></i> Rotate Left
                </button>
                <button type="button" class="crop-control-btn" onclick="cropper.rotate(90)">
                    <i class="bi bi-arrow-clockwise"></i> Rotate Right
                </button>
            </div>
            <div class="crop-control-group">
                <button type="button" class="crop-control-btn" onclick="cropper.reset()">
                    <i class="bi bi-arrow-repeat"></i> Reset
                </button>
            </div>
        </div>

        <div class="crop-buttons">
            <button type="button" class="btn-secondary" onclick="cancelCrop()">
                <i class="bi bi-x-circle"></i>
                Cancel
            </button>
            <button type="button" class="btn-primary" onclick="applyCrop()">
                <i class="bi bi-check-circle"></i>
                Apply Crop
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script>
    let cropper = null;
    let tempCroppedImage = null;

    function togglePassword(fieldId) {
        const field = document.getElementById(fieldId);
        const icon = document.getElementById(fieldId + '-icon');

        if (field.type === 'password') {
            field.type = 'text';
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
        } else {
            field.type = 'password';
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        }
    }

    // Password strength indicator (optional enhancement)
    const passwordInput = document.getElementById('password');
    const confirmInput = document.getElementById('password_confirmation');

    confirmInput.addEventListener('input', function() {
        if (this.value && this.value !== passwordInput.value) {
            this.style.borderColor = '#ef4444';
        } else if (this.value === passwordInput.value) {
            this.style.borderColor = '#10b981';
        }
    });

    function viewAvatar() {
        const modal = document.getElementById('viewModal');
        const content = document.getElementById('viewModalContent');

        // Check if temp cropped image exists (before saving)             // cropped img and about to click save
        if (tempCroppedImage) {
            content.innerHTML = `<img src="${tempCroppedImage}" alt="Avatar Preview">`;         // show cropped img
            modal.classList.add('active');       // add active when click photo
            return;
        }

        // Check if user has saved avatar
        const avatar = document.getElementById('currentAvatar');
        if (avatar) {
            content.innerHTML = `<img src="${avatar.src}" alt="Avatar">`;
            modal.classList.add('active');
        } else {
            // No photo uploaded
            content.innerHTML = `
                <div class="no-photo-message">
                    <i class="bi bi-camera-fill"></i>
                    <h3>No Photo Uploaded</h3>
                    <p>Upload a photo to set your profile picture</p>
                </div>
            `;
            modal.classList.add('active');
        }
    }

    function closeViewModal() {
        document.getElementById('viewModal').classList.remove('active');
    }

    function handleImageSelect(event) {           //
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                showCropModal(e.target.result);
            };
            reader.readAsDataURL(file);
        }
    }

    function showCropModal(imageSrc) {
        const modal = document.getElementById('cropModal');
        const image = document.getElementById('cropImage');

        modal.classList.add('active');
        image.src = imageSrc;

        // Destroy previous cropper if exists
        if (cropper) {
            cropper.destroy();
        }

        // Initialize Cropper.js
        cropper = new Cropper(image, {
            aspectRatio: 1, // Square crop for avatar
            viewMode: 1,
            dragMode: 'move',
            autoCropArea: 0.8,
            restore: false,
            guides: true,
            center: true,
            highlight: false,
            cropBoxMovable: true,
            cropBoxResizable: true,
            toggleDragModeOnDblclick: false,
        });
    }

    function applyCrop() {
        if (!cropper) return;

        // Get cropped canvas
        const canvas = cropper.getCroppedCanvas({
            width: 400,
            height: 400,
            imageSmoothingQuality: 'high'
        });

        // Convert to data URL
        const croppedDataUrl = canvas.toDataURL('image/png');
        tempCroppedImage = croppedDataUrl;

        // Update preview
        const preview = document.getElementById('avatarPreview');
        preview.innerHTML = `<img src="${croppedDataUrl}" alt="Avatar Preview">`;

        // Store in hidden field
        document.getElementById('croppedImage').value = croppedDataUrl;

        // Show save button
        document.getElementById('saveButtonWrapper').innerHTML = `
            <button type="submit" class="btn-primary">
                <i class="bi bi-check-circle"></i>
                Save Photo
            </button>
        `;

        closeCropModal();
    }

    function cancelCrop() {
        document.getElementById('avatar').value = '';
        tempCroppedImage = null;
        closeCropModal();
    }

    function closeCropModal() {
        const modal = document.getElementById('cropModal');
        modal.classList.remove('active');

        if (cropper) {
            cropper.destroy();
            cropper = null;
        }
    }

    // Close modals on Escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            closeViewModal();
            closeCropModal();
        }
    });
</script>
@endpush
@endsection


<!--
    submit a form and pass specific data to the server.
Functionality Explained
<button type="submit">: This attribute specifies that the button acts as a submit trigger for the form it is contained within (or explicitly linked to via the form attribute). Clicking it sends the form's data to the form handler.
name="remove_avatar": This gives the button a name. When the form is submitted by this specific button, a key-value pair will be included in the form data, where the key is remove_avatar.
value="1": This is the value associated with the name attribute. When the form is submitted, the server receives the data as remove_avatar=1.
class="btn-remove": This assigns a CSS class to the button. This class is used for styling the button (e.g., color, size, icon) using a corresponding CSS file.
Common Use Case
This exact structure is often used in user profile management systems (like in the source code snippets found) where a user can remove their profile picture or "avatar". When the user clicks the "Remove" button, the form data sent to the server (e.g., remove_avatar=1) signals to the backend script that the avatar deletion logic should be executed for the current user.
-->

<!--
    The provided HTML code snippets define a hidden input field intended to store data, likely a cropped image in base64 format, and an empty div that would typically contain a button to save or submit the form data using JavaScript.
Here is a breakdown of the code:
<input type="hidden" name="cropped_image" id="croppedImage">
type="hidden": This attribute specifies that the input field should be hidden from the user interface. It is used to pass data to the server when a form is submitted without the user seeing or modifying it.
name="cropped_image": This assigns a name to the input field, which is used to reference its value when the form data is sent to the server.
id="croppedImage": This provides a unique identifier for the element, primarily used by JavaScript or CSS to interact with this specific field. In the context of image cropping, JavaScript is used to get the cropped image's data (often as a base64 encoded string) and store it in this hidden input.
<div style="margin-top: 1rem;" id="saveButtonWrapper"></div>
This is a standard HTML div element.
It has an id of saveButtonWrapper, which suggests it is a container where a button (or other elements) will be dynamically added or managed using JavaScript.
The inline style="margin-top: 1rem;" adds some vertical spacing above this container.
Purpose
The elements are typically part of a webpage feature that allows users to upload and crop an image. The workflow involves:
A user uploads an image.
The user crops the image in a visible area.
JavaScript code captures the final cropped image data.
This data is then placed into the croppedImage hidden input field.
When a "Save" or "Submit" button (likely placed in saveButtonWrapper) is clicked, the entire form is sent to the server, including the hidden image data, for final processing and saving.
-->
