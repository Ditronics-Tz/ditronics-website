<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <header class="bg-white border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 py-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <img
                    src="/images/DITRONICS-COMPANY-LOGO.png"
                    alt="Ditronics"
                    width="40"
                    height="40"
                    class="rounded-full"
                >
                <div>
                    <h1 class="text-xl font-bold text-anchor-dark">Admin Dashboard</h1>
                    <p class="text-sm text-gray-500">Manage your laptops</p>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <a href="/laptops" class="btn btn-outline btn-sm">View Site</a>
                <form action="/admin/logout" method="POST" style="display: inline;">
                    <?= CSRF::field() ?>
                    <button type="submit" class="btn btn-ghost btn-sm">
                        <i data-lucide="log-out" class="w-4 h-4 mr-2"></i>
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 py-8">
        <!-- Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-lg p-6 border border-gray-200">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-lg flex items-center justify-center" style="background-color: rgba(255, 74, 0, 0.1);">
                        <i data-lucide="laptop" class="w-6 h-6 text-vermilion"></i>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-anchor-dark"><?= $stats['totalLaptops'] ?></p>
                        <p class="text-sm text-gray-500">Total Laptops</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg p-6 border border-gray-200">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-lg flex items-center justify-center" style="background-color: rgba(19, 208, 171, 0.1);">
                        <i data-lucide="laptop" class="w-6 h-6 text-teal-green"></i>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-anchor-dark"><?= $stats['inStock'] ?></p>
                        <p class="text-sm text-gray-500">In Stock</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg p-6 border border-gray-200">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-lg flex items-center justify-center" style="background-color: rgba(255, 196, 62, 0.1);">
                        <i data-lucide="laptop" class="w-6 h-6" style="color: var(--sunny);"></i>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-anchor-dark"><?= $stats['featured'] ?></p>
                        <p class="text-sm text-gray-500">Featured</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabs -->
        <div class="flex gap-4 mb-6 border-b border-gray-200">
            <button class="tab-btn active pb-3 px-1 text-sm font-medium transition-colors relative text-vermilion" data-tab="laptops">
                <div class="flex items-center gap-2">
                    <i data-lucide="laptop" class="w-4 h-4"></i>
                    Laptops
                </div>
                <div class="tab-indicator absolute bottom-0 left-0 right-0 h-0.5 bg-vermilion"></div>
            </button>
            <button class="tab-btn pb-3 px-1 text-sm font-medium transition-colors relative text-gray-500" data-tab="inquiries">
                <div class="flex items-center gap-2">
                    <i data-lucide="inbox" class="w-4 h-4"></i>
                    Inquiries
                    <?php if ($stats['unreadInquiries'] > 0): ?>
                        <span class="bg-vermilion text-white text-xs rounded-full px-2 py-0.5"><?= $stats['unreadInquiries'] ?></span>
                    <?php endif; ?>
                </div>
                <div class="tab-indicator absolute bottom-0 left-0 right-0 h-0.5 bg-vermilion hidden"></div>
            </button>
            <button class="tab-btn pb-3 px-1 text-sm font-medium transition-colors relative text-gray-500" data-tab="settings">
                <div class="flex items-center gap-2">
                    <i data-lucide="settings" class="w-4 h-4"></i>
                    Settings
                </div>
                <div class="tab-indicator absolute bottom-0 left-0 right-0 h-0.5 bg-vermilion hidden"></div>
            </button>
        </div>

        <!-- Laptops Tab -->
        <div id="tab-laptops" class="tab-content">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-semibold text-anchor-dark">Laptops</h2>
                <button id="add-laptop-btn" class="btn btn-primary">
                    <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
                    Add Laptop
                </button>
            </div>

            <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                <?php if (empty($laptops)): ?>
                    <div class="p-12 text-center">
                        <i data-lucide="laptop" class="w-12 h-12 mx-auto text-gray-300 mb-4"></i>
                        <p class="text-gray-500 mb-4">No laptops yet. Add your first laptop!</p>
                        <button class="btn btn-primary add-laptop-trigger">
                            <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
                            Add Laptop
                        </button>
                    </div>
                <?php else: ?>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50 border-b border-gray-200">
                                <tr>
                                    <th class="text-left p-4 text-sm font-medium text-gray-500">Image</th>
                                    <th class="text-left p-4 text-sm font-medium text-gray-500">Name</th>
                                    <th class="text-left p-4 text-sm font-medium text-gray-500">Price</th>
                                    <th class="text-left p-4 text-sm font-medium text-gray-500">Status</th>
                                    <th class="text-left p-4 text-sm font-medium text-gray-500">Featured</th>
                                    <th class="text-right p-4 text-sm font-medium text-gray-500">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="laptops-tbody">
                                <?php foreach ($laptops as $laptop): ?>
                                    <tr class="border-b border-gray-100 hover:bg-gray-50" data-id="<?= $laptop['id'] ?>">
                                        <td class="p-4">
                                            <div class="w-16 h-12 rounded bg-gray-100 overflow-hidden">
                                                <?php if (!empty($laptop['image'])): ?>
                                                    <img src="<?= e($laptop['image']) ?>" alt="<?= e($laptop['name']) ?>" class="w-full h-full object-cover">
                                                <?php else: ?>
                                                    <div class="w-full h-full flex items-center justify-center">
                                                        <i data-lucide="laptop" class="w-5 h-5 text-gray-300"></i>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                        <td class="p-4">
                                            <p class="font-medium text-anchor-dark"><?= e($laptop['name']) ?></p>
                                            <p class="text-sm text-gray-500"><?= e($laptop['cpu'] ?? '') ?></p>
                                        </td>
                                        <td class="p-4">
                                            <p class="font-semibold text-vermilion">
                                                <?= formatPrice($laptop['price'], $laptop['currency'] ?? 'TZS') ?>
                                            </p>
                                        </td>
                                        <td class="p-4">
                                            <span class="inline-flex px-2 py-1 rounded-full text-xs font-medium 
                                                <?php if ($laptop['stock_status'] === 'In Stock'): ?>
                                                    bg-green-100 text-green-700
                                                <?php elseif ($laptop['stock_status'] === 'Limited'): ?>
                                                    bg-yellow-100 text-yellow-700
                                                <?php else: ?>
                                                    bg-gray-100 text-gray-700
                                                <?php endif; ?>">
                                                <?= e($laptop['stock_status']) ?>
                                            </span>
                                        </td>
                                        <td class="p-4">
                                            <?php if ($laptop['featured']): ?>
                                                <span class="text-vermilion">★</span>
                                            <?php else: ?>
                                                <span class="text-gray-300">☆</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="p-4">
                                            <div class="flex items-center justify-end gap-2">
                                                <button class="edit-laptop p-2 hover:bg-gray-100 rounded-lg transition-colors" 
                                                        data-laptop='<?= e(json_encode($laptop)) ?>'>
                                                    <i data-lucide="edit" class="w-4 h-4 text-gray-500"></i>
                                                </button>
                                                <button class="delete-laptop p-2 hover:bg-red-50 rounded-lg transition-colors"
                                                        data-id="<?= $laptop['id'] ?>">
                                                    <i data-lucide="trash-2" class="w-4 h-4 text-red-500"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Inquiries Tab -->
        <div id="tab-inquiries" class="tab-content hidden">
            <div class="bg-white rounded-lg border border-gray-200">
                <div class="p-4 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-anchor-dark">Contact Inquiries</h2>
                    <p class="text-sm text-gray-500">Messages from visitors through the contact form</p>
                </div>
                
                <?php if (empty($inquiries)): ?>
                    <div class="p-12 text-center">
                        <i data-lucide="inbox" class="w-12 h-12 mx-auto text-gray-300 mb-4"></i>
                        <p class="text-gray-500">No inquiries yet</p>
                    </div>
                <?php else: ?>
                    <div class="divide-y divide-gray-100" id="inquiries-list">
                        <?php foreach ($inquiries as $inquiry): ?>
                            <div class="inquiry-item p-4 hover:bg-gray-50 cursor-pointer transition-colors <?= $inquiry['status'] === 'new' ? 'bg-blue-50/50' : '' ?>"
                                 data-inquiry='<?= e(json_encode($inquiry)) ?>'>
                                <div class="flex items-start justify-between gap-4">
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center gap-2 mb-1">
                                            <span class="font-medium text-anchor-dark"><?= e($inquiry['name']) ?></span>
                                            <?php if ($inquiry['status'] === 'new'): ?>
                                                <span class="bg-blue-100 text-blue-700 text-xs px-2 py-0.5 rounded-full">New</span>
                                            <?php elseif ($inquiry['status'] === 'replied'): ?>
                                                <span class="bg-green-100 text-green-700 text-xs px-2 py-0.5 rounded-full flex items-center gap-1">
                                                    <i data-lucide="check-circle" class="w-3 h-3"></i> Replied
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                        <p class="text-sm text-gray-500"><?= e($inquiry['email']) ?></p>
                                        <?php if (!empty($inquiry['company'])): ?>
                                            <p class="text-sm text-gray-400"><?= e($inquiry['company']) ?></p>
                                        <?php endif; ?>
                                        <p class="text-sm text-gray-600 mt-2 line-clamp-2"><?= e($inquiry['message']) ?></p>
                                    </div>
                                    <div class="text-right flex-shrink-0">
                                        <p class="text-xs text-gray-400 flex items-center gap-1">
                                            <i data-lucide="clock" class="w-3 h-3"></i>
                                            <?= formatDateTime($inquiry['created_at'], 'M d, g:i A') ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Settings Tab -->
        <div id="tab-settings" class="tab-content hidden">
            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <div class="max-w-2xl">
                    <h2 class="text-xl font-semibold text-anchor-dark mb-6">Contact Settings</h2>
                    <p class="text-sm text-gray-500 mb-6">
                        Configure the contact information that appears across the website, including WhatsApp inquiry buttons and call links.
                    </p>
                    
                    <form id="settings-form" class="space-y-6">
                        <div>
                            <label class="form-label flex items-center gap-2">
                                <i data-lucide="message-circle" class="w-4 h-4 text-green-600"></i>
                                WhatsApp Number
                            </label>
                            <input
                                type="text"
                                name="whatsapp_number"
                                value="<?= e($settings['whatsapp_number'] ?? '') ?>"
                                class="form-input"
                                placeholder="e.g. 255717321753 (without + sign)"
                            >
                            <p class="text-xs text-gray-400 mt-1">Enter the number without + or spaces (e.g., 255717321753)</p>
                        </div>
                        
                        <div>
                            <label class="form-label flex items-center gap-2">
                                <i data-lucide="phone" class="w-4 h-4 text-blue-600"></i>
                                Phone Number
                            </label>
                            <input
                                type="text"
                                name="phone_number"
                                value="<?= e($settings['phone_number'] ?? '') ?>"
                                class="form-input"
                                placeholder="e.g. 255717321753"
                            >
                            <p class="text-xs text-gray-400 mt-1">This number will be used for "Call Us" buttons</p>
                        </div>
                        
                        <div>
                            <label class="form-label flex items-center gap-2">
                                <i data-lucide="mail" class="w-4 h-4 text-red-500"></i>
                                Email Address
                            </label>
                            <input
                                type="email"
                                name="email"
                                value="<?= e($settings['email'] ?? '') ?>"
                                class="form-input"
                                placeholder="e.g. info@ditronics.co.tz"
                            >
                        </div>
                        
                        <div>
                            <label class="form-label flex items-center gap-2">
                                <i data-lucide="map-pin" class="w-4 h-4 text-orange-500"></i>
                                Address
                            </label>
                            <input
                                type="text"
                                name="address"
                                value="<?= e($settings['address'] ?? '') ?>"
                                class="form-input"
                                placeholder="e.g. Shangwe Kibada, Tanzania"
                            >
                        </div>
                        
                        <div>
                            <label class="form-label flex items-center gap-2">
                                <i data-lucide="building" class="w-4 h-4 text-purple-500"></i>
                                Company Name
                            </label>
                            <input
                                type="text"
                                name="company_name"
                                value="<?= e($settings['company_name'] ?? '') ?>"
                                class="form-input"
                                placeholder="e.g. Ditronics"
                            >
                        </div>
                        
                        <div class="pt-4 border-t border-gray-200">
                            <button type="submit" class="btn btn-primary" id="save-settings-btn">
                                <i data-lucide="save" class="w-4 h-4 mr-2"></i>
                                Save Settings
                            </button>
                            <span id="settings-saved" class="ml-4 text-sm text-green-600 hidden">✓ Settings saved successfully!</span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
</div>

<!-- Laptop Form Modal -->
<div id="laptop-modal" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4 hidden">
    <div class="bg-white rounded-lg w-full max-w-2xl max-h-[90vh] overflow-y-auto">
        <div class="sticky top-0 bg-white border-b border-gray-200 p-4 flex items-center justify-between">
            <h3 class="text-lg font-semibold" id="modal-title">Add New Laptop</h3>
            <button id="close-modal" class="p-2 hover:bg-gray-100 rounded-lg">
                <i data-lucide="x" class="w-6 h-6"></i>
            </button>
        </div>
        
        <form id="laptop-form" class="p-6 space-y-4" enctype="multipart/form-data">
            <input type="hidden" name="id" id="laptop-id">
            
            <div class="grid grid-cols-2 gap-4">
                <div class="col-span-2">
                    <label class="form-label">Laptop Name *</label>
                    <input type="text" name="name" required class="form-input" placeholder="e.g. Dell XPS 15 9530">
                </div>
                
                <div>
                    <label class="form-label">Price (TZS) *</label>
                    <input type="number" name="price" required class="form-input" placeholder="e.g. 2500000">
                </div>
                
                <div>
                    <label class="form-label">Currency</label>
                    <select name="currency" class="form-input form-select">
                        <option value="TZS">TZS</option>
                        <option value="USD">USD</option>
                    </select>
                </div>
                
                <div class="col-span-2">
                    <label class="form-label">CPU / Processor</label>
                    <input type="text" name="cpu" class="form-input" placeholder="e.g. Intel Core i7-13700H">
                </div>
                
                <div>
                    <label class="form-label">RAM</label>
                    <input type="text" name="ram" class="form-input" placeholder="e.g. 16GB DDR5">
                </div>
                
                <div>
                    <label class="form-label">Storage</label>
                    <input type="text" name="storage" class="form-input" placeholder="e.g. 512GB NVMe SSD">
                </div>
                
                <div class="col-span-2">
                    <label class="form-label">GPU / Graphics</label>
                    <input type="text" name="gpu" class="form-input" placeholder="e.g. NVIDIA GeForce RTX 4060">
                </div>
                
                <div>
                    <label class="form-label">Display</label>
                    <input type="text" name="display" class="form-input" placeholder="e.g. 15.6 FHD IPS 120Hz">
                </div>
                
                <div>
                    <label class="form-label">Battery</label>
                    <input type="text" name="battery" class="form-input" placeholder="e.g. 86Wh">
                </div>
                
                <div>
                    <label class="form-label">Stock Status</label>
                    <select name="stock_status" class="form-input form-select">
                        <option value="In Stock">In Stock</option>
                        <option value="Limited">Limited</option>
                        <option value="Out of Stock">Out of Stock</option>
                    </select>
                </div>
                
                <div>
                    <label class="form-label">Condition</label>
                    <select name="condition" class="form-input form-select">
                        <option value="Brand New">Brand New</option>
                        <option value="Refurbished">Refurbished</option>
                        <option value="Used - Like New">Used - Like New</option>
                        <option value="Used - Good">Used - Good</option>
                    </select>
                </div>

                <!-- Extended Specs -->
                <div class="col-span-2 border-t border-gray-200 pt-4 mt-2">
                    <h4 class="text-sm font-semibold text-anchor-dark mb-4">Additional Details</h4>
                </div>
                
                <div>
                    <label class="form-label">Brand</label>
                    <input type="text" name="brand" class="form-input" placeholder="e.g. Dell">
                </div>
                
                <div>
                    <label class="form-label">Model Number</label>
                    <input type="text" name="model_number" class="form-input" placeholder="e.g. XPS 15 9530">
                </div>
                
                <div>
                    <label class="form-label">Operating System</label>
                    <input type="text" name="os" class="form-input" placeholder="e.g. Windows 11 Pro">
                </div>
                
                <div>
                    <label class="form-label">Color</label>
                    <input type="text" name="color" class="form-input" placeholder="e.g. Silver">
                </div>
                
                <div>
                    <label class="form-label">Webcam</label>
                    <input type="text" name="webcam" class="form-input" placeholder="e.g. 1080p FHD">
                </div>
                
                <div>
                    <label class="form-label">Keyboard</label>
                    <input type="text" name="keyboard" class="form-input" placeholder="e.g. Backlit">
                </div>
                
                <div>
                    <label class="form-label">WiFi</label>
                    <input type="text" name="wifi" class="form-input" placeholder="e.g. WiFi 6E">
                </div>
                
                <div>
                    <label class="form-label">Bluetooth</label>
                    <input type="text" name="bluetooth" class="form-input" placeholder="e.g. Bluetooth 5.3">
                </div>
                
                <div>
                    <label class="form-label">Weight</label>
                    <input type="text" name="weight" class="form-input" placeholder="e.g. 1.8 - 2.0 kg">
                </div>
                
                <div>
                    <label class="form-label">Warranty</label>
                    <input type="text" name="warranty" class="form-input" placeholder="e.g. 1 Year">
                </div>
                
                <div class="col-span-2">
                    <label class="form-label">Ports (comma separated)</label>
                    <input type="text" name="ports" class="form-input" placeholder="e.g. USB-C x2, USB-A x1, HDMI">
                </div>
                
                <div class="col-span-2">
                    <label class="form-label">Dimensions</label>
                    <input type="text" name="dimensions" class="form-input" placeholder="e.g. 344 x 230 x 18 mm">
                </div>
                
                <div class="col-span-2">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-input form-textarea" rows="3" placeholder="Detailed description..."></textarea>
                </div>
                
                <div class="col-span-2 border-t border-gray-200 pt-4 mt-2">
                    <h4 class="text-sm font-semibold text-anchor-dark mb-4">Media & Status</h4>
                </div>
                
                <div class="col-span-2">
                    <label class="form-label">Image</label>
                    <div class="flex items-center gap-4">
                        <label class="flex-1 border-2 border-dashed border-gray-300 rounded-lg p-4 cursor-pointer hover:border-vermilion transition-colors">
                            <input type="file" name="image" accept="image/*" class="hidden" id="image-input">
                            <div class="flex items-center justify-center gap-2 text-gray-500">
                                <i data-lucide="upload" class="w-5 h-5"></i>
                                <span>Click to upload image</span>
                            </div>
                        </label>
                        <div id="image-preview" class="w-24 h-24 rounded-lg overflow-hidden bg-gray-100 hidden">
                            <img src="" alt="Preview" class="w-full h-full object-cover">
                        </div>
                    </div>
                </div>
                
                <div class="col-span-2">
                    <label class="form-label">Notes</label>
                    <textarea name="notes" class="form-input form-textarea" rows="2" placeholder="Additional notes..."></textarea>
                </div>
                
                <div class="col-span-2">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="featured" value="true" class="form-checkbox">
                        <span class="text-sm font-medium">Featured on homepage</span>
                    </label>
                </div>
            </div>
            
            <div class="flex gap-4 pt-4">
                <button type="submit" class="btn btn-primary flex-1">
                    <i data-lucide="save" class="w-4 h-4 mr-2"></i>
                    Save Laptop
                </button>
                <button type="button" id="cancel-modal" class="btn btn-outline">Cancel</button>
            </div>
        </form>
    </div>
</div>

<!-- Inquiry Detail Modal -->
<div id="inquiry-modal" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4 hidden">
    <div class="bg-white rounded-lg w-full max-w-xl">
        <div class="p-4 border-b border-gray-200 flex items-center justify-between">
            <h3 class="text-lg font-semibold">Inquiry Details</h3>
            <button id="close-inquiry-modal" class="p-2 hover:bg-gray-100 rounded-lg">
                <i data-lucide="x" class="w-6 h-6"></i>
            </button>
        </div>
        
        <div class="p-6 space-y-4">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Name</label>
                    <p class="text-anchor-dark" id="inquiry-name"></p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Email</label>
                    <a href="#" id="inquiry-email" class="text-vermilion hover:underline"></a>
                </div>
                <div class="col-span-2" id="inquiry-company-container">
                    <label class="block text-sm font-medium text-gray-500 mb-1">Company</label>
                    <p class="text-anchor-dark" id="inquiry-company"></p>
                </div>
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-500 mb-1">Message</label>
                    <p class="text-anchor-dark whitespace-pre-wrap bg-gray-50 p-4 rounded-lg" id="inquiry-message"></p>
                </div>
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-500 mb-1">Received</label>
                    <p class="text-gray-600" id="inquiry-date"></p>
                </div>
            </div>
            
            <div class="flex gap-3 pt-4 border-t border-gray-200">
                <a href="#" id="reply-email-btn" class="btn btn-primary flex-1">
                    <i data-lucide="mail" class="w-4 h-4 mr-2"></i>
                    Reply via Email
                </a>
                <button id="mark-replied-btn" class="btn btn-outline">
                    <i data-lucide="check-circle" class="w-4 h-4 mr-2"></i>
                    Mark as Replied
                </button>
                <button id="delete-inquiry-btn" class="btn btn-ghost text-red-500 hover:text-red-600 hover:bg-red-50">
                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<style>
.space-y-4 > * + * { margin-top: 1rem; }
.space-y-6 > * + * { margin-top: 1.5rem; }
.divide-y > * + * { border-top-width: 1px; }
.divide-gray-100 > * + * { border-color: #f3f4f6; }
.h-0\.5 { height: 0.125rem; }
.tab-btn:not(.active) .tab-indicator { display: none; }
.tab-btn.active { color: var(--vermilion); }
.tab-btn.active .tab-indicator { display: block; }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const csrfToken = <?= json_encode($csrfToken, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>;
    
    // Tab switching
    const tabBtns = document.querySelectorAll('.tab-btn');
    const tabContents = document.querySelectorAll('.tab-content');
    
    tabBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            tabBtns.forEach(b => {
                b.classList.remove('active', 'text-vermilion');
                b.classList.add('text-gray-500');
            });
            btn.classList.add('active', 'text-vermilion');
            btn.classList.remove('text-gray-500');
            
            tabContents.forEach(c => c.classList.add('hidden'));
            document.getElementById('tab-' + btn.dataset.tab).classList.remove('hidden');
        });
    });

    // Modal handling
    const laptopModal = document.getElementById('laptop-modal');
    const laptopForm = document.getElementById('laptop-form');
    const modalTitle = document.getElementById('modal-title');
    
    document.getElementById('add-laptop-btn')?.addEventListener('click', openAddModal);
    document.querySelectorAll('.add-laptop-trigger').forEach(btn => btn.addEventListener('click', openAddModal));
    document.getElementById('close-modal')?.addEventListener('click', closeModal);
    document.getElementById('cancel-modal')?.addEventListener('click', closeModal);
    
    function openAddModal() {
        modalTitle.textContent = 'Add New Laptop';
        laptopForm.reset();
        document.getElementById('laptop-id').value = '';
        document.getElementById('image-preview').classList.add('hidden');
        laptopModal.classList.remove('hidden');
        lucide.createIcons();
    }
    
    function closeModal() {
        laptopModal.classList.add('hidden');
        laptopForm.reset();
    }
    
    // Edit laptop
    document.querySelectorAll('.edit-laptop').forEach(btn => {
        btn.addEventListener('click', () => {
            const laptop = JSON.parse(btn.dataset.laptop);
            modalTitle.textContent = 'Edit Laptop';
            
            document.getElementById('laptop-id').value = laptop.id;
            laptopForm.querySelector('[name="name"]').value = laptop.name || '';
            laptopForm.querySelector('[name="price"]').value = laptop.price || '';
            laptopForm.querySelector('[name="currency"]').value = laptop.currency || 'TZS';
            laptopForm.querySelector('[name="cpu"]').value = laptop.cpu || '';
            laptopForm.querySelector('[name="ram"]').value = laptop.ram || '';
            laptopForm.querySelector('[name="storage"]').value = laptop.storage || '';
            laptopForm.querySelector('[name="gpu"]').value = laptop.gpu || '';
            laptopForm.querySelector('[name="display"]').value = laptop.display || '';
            laptopForm.querySelector('[name="battery"]').value = laptop.battery || '';
            laptopForm.querySelector('[name="stock_status"]').value = laptop.stock_status || 'In Stock';
            laptopForm.querySelector('[name="condition"]').value = laptop.condition || 'Brand New';
            laptopForm.querySelector('[name="brand"]').value = laptop.brand || '';
            laptopForm.querySelector('[name="model_number"]').value = laptop.model_number || '';
            laptopForm.querySelector('[name="os"]').value = laptop.os || '';
            laptopForm.querySelector('[name="color"]').value = laptop.color || '';
            laptopForm.querySelector('[name="webcam"]').value = laptop.webcam || '';
            laptopForm.querySelector('[name="keyboard"]').value = laptop.keyboard || '';
            laptopForm.querySelector('[name="wifi"]').value = laptop.wifi || '';
            laptopForm.querySelector('[name="bluetooth"]').value = laptop.bluetooth || '';
            laptopForm.querySelector('[name="weight"]').value = laptop.weight || '';
            laptopForm.querySelector('[name="warranty"]').value = laptop.warranty || '';
            laptopForm.querySelector('[name="ports"]').value = laptop.ports || '';
            laptopForm.querySelector('[name="dimensions"]').value = laptop.dimensions || '';
            laptopForm.querySelector('[name="description"]').value = laptop.description || '';
            laptopForm.querySelector('[name="notes"]').value = laptop.notes || '';
            laptopForm.querySelector('[name="featured"]').checked = !!laptop.featured;
            
            if (laptop.image) {
                const preview = document.getElementById('image-preview');
                preview.querySelector('img').src = laptop.image;
                preview.classList.remove('hidden');
            } else {
                document.getElementById('image-preview').classList.add('hidden');
            }
            
            laptopModal.classList.remove('hidden');
            lucide.createIcons();
        });
    });
    
    // Image preview
    document.getElementById('image-input')?.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('image-preview');
                preview.querySelector('img').src = e.target.result;
                preview.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        }
    });
    
    // Submit laptop form
    laptopForm?.addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(laptopForm);
        const id = document.getElementById('laptop-id').value;
        
        const method = id ? 'PUT' : 'POST';
        
        try {
            const response = await fetch('/api/laptops', {
                method: method,
                body: formData,
            });
            
            if (response.ok) {
                window.location.reload();
            } else {
                alert('Failed to save laptop');
            }
        } catch (err) {
            alert('Error saving laptop');
        }
    });
    
    // Delete laptop
    document.querySelectorAll('.delete-laptop').forEach(btn => {
        btn.addEventListener('click', async () => {
            if (!confirm('Are you sure you want to delete this laptop?')) return;
            
            const id = btn.dataset.id;
            
            try {
                const response = await fetch('/api/laptops', {
                    method: 'DELETE',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ id: parseInt(id) }),
                });
                
                if (response.ok) {
                    btn.closest('tr').remove();
                } else {
                    alert('Failed to delete laptop');
                }
            } catch (err) {
                alert('Error deleting laptop');
            }
        });
    });
    
    // Settings form
    document.getElementById('settings-form')?.addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(e.target);
        const data = Object.fromEntries(formData);
        
        try {
            const response = await fetch('/api/settings', {
                method: 'PUT',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data),
            });
            
            if (response.ok) {
                document.getElementById('settings-saved').classList.remove('hidden');
                setTimeout(() => {
                    document.getElementById('settings-saved').classList.add('hidden');
                }, 3000);
            } else {
                alert('Failed to save settings');
            }
        } catch (err) {
            alert('Error saving settings');
        }
    });
    
    // Inquiry handling
    const inquiryModal = document.getElementById('inquiry-modal');
    let currentInquiry = null;
    
    document.querySelectorAll('.inquiry-item').forEach(item => {
        item.addEventListener('click', () => {
            currentInquiry = JSON.parse(item.dataset.inquiry);
            
            document.getElementById('inquiry-name').textContent = currentInquiry.name;
            document.getElementById('inquiry-email').textContent = currentInquiry.email;
            document.getElementById('inquiry-email').href = 'mailto:' + currentInquiry.email;
            
            if (currentInquiry.company) {
                document.getElementById('inquiry-company').textContent = currentInquiry.company;
                document.getElementById('inquiry-company-container').classList.remove('hidden');
            } else {
                document.getElementById('inquiry-company-container').classList.add('hidden');
            }
            
            document.getElementById('inquiry-message').textContent = currentInquiry.message;
            document.getElementById('inquiry-date').textContent = new Date(currentInquiry.created_at).toLocaleString();
            document.getElementById('reply-email-btn').href = 'mailto:' + currentInquiry.email + '?subject=Re: Your inquiry to Ditronics';
            
            inquiryModal.classList.remove('hidden');
            lucide.createIcons();
            
            // Mark as read if new
            if (currentInquiry.status === 'new') {
                fetch('/api/inquiries', {
                    method: 'PUT',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ id: currentInquiry.id, action: 'read' }),
                });
                item.classList.remove('bg-blue-50/50');
            }
        });
    });
    
    document.getElementById('close-inquiry-modal')?.addEventListener('click', () => {
        inquiryModal.classList.add('hidden');
    });
    
    document.getElementById('mark-replied-btn')?.addEventListener('click', async () => {
        if (!currentInquiry) return;
        
        await fetch('/api/inquiries', {
            method: 'PUT',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id: currentInquiry.id, action: 'replied' }),
        });
        
        window.location.reload();
    });
    
    document.getElementById('delete-inquiry-btn')?.addEventListener('click', async () => {
        if (!currentInquiry || !confirm('Are you sure you want to delete this inquiry?')) return;
        
        await fetch('/api/inquiries', {
            method: 'DELETE',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id: currentInquiry.id }),
        });
        
        window.location.reload();
    });
    
    // Initialize icons
    lucide.createIcons();
});
</script>
