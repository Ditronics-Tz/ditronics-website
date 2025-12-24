<?php
// Sample services data (same as Next.js)
$services = [
    [
        'id' => 'software-integration',
        'title' => 'Software & Integration Services',
        'description' => 'Seamlessly connect your business systems with custom software integrations. APIs, data pipelines, and enterprise software deployment.',
        'icon' => 'code',
        'priceTier' => 'Enterprise',
        'features' => [
            'API development & integration',
            'Enterprise software deployment',
            'Data pipeline automation',
            'Third-party system connectivity',
            'Legacy system modernization',
        ],
    ],
    [
        'id' => 'it-infrastructure',
        'title' => 'IT Infrastructure & Support',
        'description' => 'Comprehensive IT infrastructure management and support services. From network setup to 24/7 monitoring and maintenance.',
        'icon' => 'server',
        'priceTier' => 'Pro',
        'features' => [
            'Network design & implementation',
            'Server management & virtualization',
            'Cloud infrastructure setup',
            '24/7 monitoring & support',
            'Disaster recovery planning',
        ],
    ],
    [
        'id' => 'custom-software',
        'title' => 'Custom Business Software',
        'description' => 'Bespoke software solutions tailored to your business processes. Web applications, automation tools, and enterprise systems.',
        'icon' => 'laptop',
        'priceTier' => 'Enterprise',
        'features' => [
            'Custom web applications',
            'Business process automation',
            'Database design & optimization',
            'Enterprise resource planning',
            'Inventory & workflow systems',
        ],
    ],
    [
        'id' => 'electrical-electronics',
        'title' => 'Electrical & Electronics Engineering',
        'description' => 'Professional electrical and electronics engineering services. Circuit design, PCB development, embedded systems, and power solutions.',
        'icon' => 'zap',
        'priceTier' => 'Enterprise',
        'features' => [
            'Circuit design & analysis',
            'PCB design & prototyping',
            'Embedded systems development',
            'Power electronics & systems',
            'Hardware testing & validation',
        ],
    ],
    [
        'id' => 'research-development',
        'title' => 'Research & Development',
        'description' => 'Cutting-edge R&D services to bring innovative ideas to life. Prototyping, proof-of-concept, and technology exploration.',
        'icon' => 'lightbulb',
        'priceTier' => 'Enterprise',
        'features' => [
            'Technology research & analysis',
            'Prototype development',
            'Proof-of-concept builds',
            'Innovation consulting',
            'Technical feasibility studies',
        ],
    ],
    [
        'id' => 'tech-consulting',
        'title' => 'Technology Consulting',
        'description' => 'Strategic technology consulting to align your IT investments with business objectives and drive digital transformation.',
        'icon' => 'compass',
        'priceTier' => 'Pro',
        'features' => [
            'Technology roadmapping',
            'Digital transformation strategy',
            'Vendor evaluation & selection',
            'Architecture review',
            'Process optimization',
        ],
    ],
];

$benefits = [
    'Custom software & integration solutions',
    'IT infrastructure & support',
    'DSP, R&D, and innovation consulting',
];

$tierColors = [
    'Starter' => 'badge-secondary',
    'Pro' => 'badge-warning',
    'Enterprise' => 'badge-success',
];
?>

<!-- Hero Section -->
<section class="hero-section">
    <div class="container relative py-20 md:py-32 lg:py-40">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <!-- Content -->
            <div class="text-center lg:text-left">
                <!-- Badge -->
                <div class="hero-badge mb-6">
                    <span class="hero-badge-dot"></span>
                    Trusted by clients
                </div>

                <!-- Heading -->
                <h1 class="text-anchor-dark mb-6">
                    Optimize Your Tech with
                    <span class="text-vermilion">Ditronics</span>
                </h1>

                <!-- Subtext -->
                <p class="text-lg md:text-xl text-neutral-text mb-8 max-w-xl mx-auto lg:mx-0">
                    Software integration, custom business solutions, and cutting-edge R&D
                    with enterprise-grade support. We make complex tech simple.
                </p>

                <!-- Benefits -->
                <ul class="flex flex-col gap-3 mb-8">
                    <?php foreach ($benefits as $benefit): ?>
                        <li class="flex items-center gap-3 text-neutral-text justify-center lg:justify-start">
                            <i data-lucide="check-circle" class="w-5 h-5 text-teal-green flex-shrink-0"></i>
                            <?= e($benefit) ?>
                        </li>
                    <?php endforeach; ?>
                </ul>

                <!-- CTAs -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                    <a href="/services" class="btn btn-primary btn-lg gap-2">
                        Explore Services
                        <i data-lucide="arrow-right" class="w-5 h-5"></i>
                    </a>
                    <a href="/laptops" class="btn btn-secondary btn-lg">
                        View Laptops
                    </a>
                </div>
            </div>

            <!-- Visual Element -->
            <div class="relative hidden lg:block">
                <div class="relative aspect-square max-w-lg mx-auto">
                    <!-- Decorative circles -->
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="w-72 h-72 rounded-full" style="background-color: rgba(255, 74, 0, 0.05); animation: pulse 2s infinite;"></div>
                    </div>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="w-56 h-56 rounded-full" style="background-color: rgba(19, 208, 171, 0.05);"></div>
                    </div>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="w-40 h-40 rounded-full" style="background-color: rgba(19, 208, 171, 0.1);"></div>
                    </div>
                    
                    <!-- Center icon -->
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="w-24 h-24 rounded-2xl bg-white shadow-lg flex items-center justify-center overflow-hidden">
                            <img src="/public/images/DITRONICS-COMPANY-LOGO.png" alt="Ditronics Logo" width="80" height="80" class="rounded-xl">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Services Section -->
<section class="py-20 bg-off-white">
    <div class="container">
        <div class="text-center mb-12">
            <h2 class="mb-4">Our Services</h2>
            <p class="text-lg text-neutral-text max-w-2xl mx-auto">
                From software integration to custom business solutions and R&D, we provide
                comprehensive technology services tailored to your business needs.
            </p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach (array_slice($services, 0, 6) as $index => $service): ?>
                <div class="card group">
                    <div class="card-header">
                        <div class="flex items-start justify-between mb-4">
                            <div class="service-icon">
                                <i data-lucide="<?= e($service['icon']) ?>" class="w-6 h-6"></i>
                            </div>
                            <span class="badge <?= $tierColors[$service['priceTier']] ?? 'badge-secondary' ?>">
                                <?= e($service['priceTier']) ?>
                            </span>
                        </div>
                        <h3 class="card-title group-hover:text-vermilion transition-colors">
                            <?= e($service['title']) ?>
                        </h3>
                        <p class="card-description mt-2">
                            <?= e($service['description']) ?>
                        </p>
                    </div>
                    <div class="card-content">
                        <ul class="space-y-2 mb-6">
                            <?php foreach (array_slice($service['features'], 0, 4) as $feature): ?>
                                <li class="text-sm text-neutral-text flex items-center gap-2">
                                    <span class="w-1.5 h-1.5 rounded-full bg-teal-green"></span>
                                    <?= e($feature) ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                        <a href="/services#<?= e($service['id']) ?>" class="btn btn-ghost w-full">
                            Learn More
                            <i data-lucide="arrow-right" class="w-4 h-4 ml-2"></i>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-20 bg-anchor-dark">
    <div class="container text-center">
        <h2 class="text-white mb-4">Ready to Build Something Great?</h2>
        <p class="text-gray-400 text-lg max-w-2xl mx-auto mb-8">
            Partner with Ditronics for custom software, IT infrastructure, and innovative R&D solutions. Get started today.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="/contact" class="btn btn-primary btn-lg">
                Get Started
                <i data-lucide="arrow-right" class="w-5 h-5 ml-2"></i>
            </a>
            <a href="/services" class="btn btn-lg border-white text-white hover:bg-white hover:text-anchor-dark" style="background: transparent; border: 2px solid white;">
                Our Services
            </a>
        </div>
    </div>
</section>

<style>
.space-y-2 > * + * { margin-top: 0.5rem; }
.bg-teal-green { background-color: var(--teal-green); }
.items-center { align-items: center; }
</style>
