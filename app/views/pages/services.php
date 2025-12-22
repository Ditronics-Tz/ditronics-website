<?php
// Sample services data
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

$tierColors = [
    'Starter' => 'badge-secondary',
    'Pro' => 'badge-warning',
    'Enterprise' => 'badge-success',
];

$whyChooseUs = [
    'Reliable service with consistent quality delivery',
    'Dedicated support from skilled technicians',
    'Transparent communication and fair pricing',
    'Tailored solutions for your specific needs',
    'Focus on long-term partnerships and growth',
];

$stats = [
    ['value' => '50+', 'label' => 'Projects Completed'],
    ['value' => '98%', 'label' => 'Client Satisfaction'],
    ['value' => '24/7', 'label' => 'Support Available'],
    ['value' => '5+', 'label' => 'Years Experience'],
];
?>

<!-- Hero Section -->
<section class="py-20 bg-gradient-hero">
    <div class="container">
        <div class="max-w-3xl mx-auto text-center">
            <h1 class="mb-6">Our Services</h1>
            <p class="text-xl text-neutral-text mb-8">
                From software integration to custom business solutions and R&D, we provide
                comprehensive technology services tailored to your business needs.
            </p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="/contact" class="btn btn-primary btn-lg">
                    Get a Quote
                    <i data-lucide="arrow-right" class="w-5 h-5 ml-2"></i>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Services Grid -->
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
            <?php foreach ($services as $service): ?>
                <div id="<?= e($service['id']) ?>" class="card group">
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
                            <?php foreach ($service['features'] as $feature): ?>
                                <li class="text-sm text-neutral-text flex items-center gap-2">
                                    <span class="w-1.5 h-1.5 rounded-full bg-teal-green"></span>
                                    <?= e($feature) ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Why Choose Us Section -->
<section class="py-20 bg-white">
    <div class="container">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <div>
                <h2 class="mb-6">Why Choose Ditronics?</h2>
                <p class="text-lg text-neutral-text mb-8">
                    We bring dedication, technical expertise, and a client-first approach
                    to every project. Our team understands the unique challenges businesses
                    face with technology.
                </p>
                <ul class="space-y-4">
                    <?php foreach ($whyChooseUs as $item): ?>
                        <li class="flex items-start gap-3">
                            <i data-lucide="check-circle" class="w-6 h-6 text-teal-green flex-shrink-0 mt-0.5"></i>
                            <span class="text-neutral-text"><?= e($item) ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="bg-off-white rounded-lg p-8">
                <div class="grid grid-cols-2 gap-6">
                    <?php foreach ($stats as $stat): ?>
                        <div class="text-center">
                            <p class="text-3xl font-bold text-vermilion"><?= e($stat['value']) ?></p>
                            <p class="text-sm text-neutral-text"><?= e($stat['label']) ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-20 bg-anchor-dark">
    <div class="container text-center">
        <h2 class="text-white mb-4">Ready to Get Started?</h2>
        <p class="text-gray-400 text-lg max-w-2xl mx-auto mb-8">
            Contact us today for a free consultation and discover how we can
            optimize your technology infrastructure.
        </p>
        <a href="/contact" class="btn btn-primary btn-lg">
            Schedule Consultation
            <i data-lucide="arrow-right" class="w-5 h-5 ml-2"></i>
        </a>
    </div>
</section>

<style>
.space-y-2 > * + * { margin-top: 0.5rem; }
.space-y-4 > * + * { margin-top: 1rem; }
.bg-teal-green { background-color: var(--teal-green); }
.mt-0\.5 { margin-top: 0.125rem; }
</style>
