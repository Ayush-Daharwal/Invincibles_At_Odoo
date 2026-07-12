<?php

namespace Transitops\RegistryBridge\Seeders;

use Transitops\Models\Category;
use Illuminate\Database\Seeder;

class ExtensionsCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                'name' => 'Telematics',
                'description' => 'Advanced tracking and diagnostics for vehicle fleets, including real-time data and analytics.',
                'internal_id' => 'TROTELEMATICS',
                'icon' => 'satellite-dish',
                'tags' => ['tracking', 'diagnostics', 'real-time', 'analytics'],
                'for' => 'extension_category'
            ],
            [
                'name' => 'Inventory',
                'description' => 'Tools for inventory management, stock control, and supply chain visibility.',
                'internal_id' => 'TROINVENTORY',
                'icon' => 'boxes-packing',
                'tags' => ['management', 'stock', 'supply chain'],
                'for' => 'extension_category'
            ],
            [
                'name' => 'Accounting',
                'description' => 'Financial management solutions including invoicing, expense tracking, and financial reporting.',
                'internal_id' => 'TROACCOUNTING',
                'icon' => 'cash-register',
                'tags' => ['finance', 'invoicing', 'expenses', 'reporting'],
                'for' => 'extension_category'
            ],
            [
                'name' => 'Route Optimization',
                'description' => 'Enhancements for efficient route planning and optimization to reduce travel time and costs.',
                'internal_id' => 'TROROUTE',
                'icon' => 'route',
                'tags' => ['route', 'planning', 'optimization', 'GPS', 'mapping'],
                'for' => 'extension_category'
            ],
            [
                'name' => 'Fleet Management',
                'description' => 'Tools for managing fleet vehicles, including maintenance, tracking, and performance analysis.',
                'internal_id' => 'TROFLEET',
                'icon' => 'truck-moving',
                'tags' => ['vehicles', 'maintenance', 'tracking', 'analytics'],
                'for' => 'extension_category'
            ],
            [
                'name' => 'Order Management',
                'description' => 'Solutions for handling orders from placement to delivery, including tracking and customer communication.',
                'internal_id' => 'TROORDER',
                'icon' => 'clipboard-list',
                'tags' => ['orders', 'tracking', 'delivery', 'customer service'],
                'for' => 'extension_category'
            ],
            [
                'name' => 'Warehouse Management',
                'description' => 'Systems for managing warehouse operations, inventory storage, and logistics.',
                'internal_id' => 'TROWAREHOUSE',
                'icon' => 'warehouse',
                'tags' => ['warehouse', 'inventory', 'logistics', 'storage'],
                'for' => 'extension_category'
            ],
            [
                'name' => 'Compliance and Regulations',
                'description' => 'Tools to ensure compliance with local and international shipping and logistics regulations.',
                'internal_id' => 'TROCOMPLIANCE',
                'icon' => 'scale-balanced',
                'tags' => ['compliance', 'regulations', 'shipping', 'international'],
                'for' => 'extension_category'
            ],
            [
                'name' => 'Analytics and Reporting',
                'description' => 'Advanced analytics and reporting tools for insights into logistics operations.',
                'internal_id' => 'TROANALYTICS',
                'icon' => 'chart-line',
                'tags' => ['analytics', 'reporting', 'data', 'insights'],
                'for' => 'extension_category'
            ],
            [
                'name' => 'Customer Relationship Management (CRM)',
                'description' => 'Extensions to manage customer interactions, support, and relationships.',
                'internal_id' => 'TROCRM',
                'icon' => 'users',
                'tags' => ['CRM', 'customer', 'support', 'relationship'],
                'for' => 'extension_category'
            ],
            [
                'name' => 'E-commerce',
                'description' => 'Comprehensive e-commerce solutions, ranging from integration tools with existing platforms to complete e-commerce applications, enhancing online retail and digital transactions.',
                'internal_id' => 'TROECOMMERCE',
                'icon' => 'store',
                'tags' => ['e-commerce', 'integration', 'shopping', 'online'],
                'for' => 'extension_category'
            ],
            [
                'name' => 'Security and Risk Management',
                'description' => 'Enhancements for improving security and managing risks in logistics operations.',
                'internal_id' => 'TROSECURITY',
                'icon' => 'shield-alt',
                'tags' => ['security', 'risk management', 'safety', 'protection'],
                'for' => 'extension_category'
            ],
            [
                'name' => 'Transportation Management',
                'description' => 'Solutions for managing and optimizing different modes of transportation, including carrier selection and freight consolidation.',
                'internal_id' => 'TROTRANSPORT',
                'icon' => 'truck-fast',
                'tags' => ['transportation', 'freight', 'carrier management', 'optimization'],
                'for' => 'extension_category'
            ],
            [
                'name' => 'Customs and Trade Compliance',
                'description' => 'Tools to navigate and comply with international trade laws, customs regulations, and import/export requirements.',
                'internal_id' => 'TROCUSTOMS',
                'icon' => 'passport',
                'tags' => ['customs', 'trade', 'compliance', 'import', 'export'],
                'for' => 'extension_category'
            ],
            [
                'name' => 'Supplier Relationship Management',
                'description' => 'Extensions to manage and enhance relationships with suppliers, including communication and performance tracking.',
                'internal_id' => 'TROSUPPLIER',
                'icon' => 'handshake',
                'tags' => ['suppliers', 'relationship management', 'performance', 'communication'],
                'for' => 'extension_category'
            ],
            [
                'name' => 'Quality Control',
                'description' => 'Tools for quality assurance in supply chain processes, including product inspections and compliance monitoring.',
                'internal_id' => 'TROQUALITY',
                'icon' => 'check-circle',
                'tags' => ['quality control', 'inspection', 'compliance', 'assurance'],
                'for' => 'extension_category'
            ],
            [
                'name' => 'Forecasting and Demand Planning',
                'description' => 'Analytical tools for accurate demand forecasting and inventory optimization based on market trends and data analysis.',
                'internal_id' => 'TROFORECASTING',
                'icon' => 'magnifying-glass-location',
                'tags' => ['forecasting', 'demand planning', 'inventory', 'market trends'],
                'for' => 'extension_category'
            ],
            [
                'name' => 'Procurement and Purchasing',
                'description' => 'Solutions for managing procurement processes, including purchase orders, vendor selection, and contract management.',
                'internal_id' => 'TROPROCUREMENT',
                'icon' => 'basket-shopping',
                'tags' => ['procurement', 'purchasing', 'vendors', 'contracts'],
                'for' => 'extension_category'
            ],
            [
                'name' => 'Asset Tracking and Management',
                'description' => 'Tools for tracking and managing assets within the supply chain, including RFID, barcode, and IoT technologies.',
                'internal_id' => 'TROASSET',
                'icon' => 'barcode',
                'tags' => ['asset tracking', 'management', 'RFID', 'IoT'],
                'for' => 'extension_category'
            ],
            [
                'name' => 'Sustainability and Environmental Compliance',
                'description' => 'Solutions focused on environmental compliance and sustainable practices in logistics and supply chain operations.',
                'internal_id' => 'TROENVIRONMENT',
                'icon' => 'leaf',
                'tags' => ['sustainability', 'environmental compliance', 'green logistics', 'eco-friendly'],
                'for' => 'extension_category'
            ],
            [
                'name' => 'Human Resources Management',
                'description' => 'Extensions for managing logistics workforce, including scheduling, training, and performance evaluations.',
                'internal_id' => 'TROHR',
                'icon' => 'user-tie',
                'tags' => ['human resources', 'workforce management', 'training', 'scheduling'],
                'for' => 'extension_category'
            ],
            [
                'name' => 'Collaboration and Communication Tools',
                'description' => 'Platforms and tools to facilitate effective collaboration and communication among supply chain stakeholders.',
                'internal_id' => 'TROCOLLABORATION',
                'icon' => 'comments',
                'tags' => ['collaboration', 'communication', 'teamwork', 'stakeholders'],
                'for' => 'extension_category'
            ],
            [
                'name' => 'Artificial Intelligence',
                'description' => 'Advanced AI-driven tools and applications for predictive analytics, automation, and intelligent decision-making in logistics.',
                'internal_id' => 'TROAI',
                'icon' => 'robot',
                'tags' => ['AI', 'predictive analytics', 'automation', 'intelligence'],
                'for' => 'extension_category'
            ],
            [
                'name' => 'Freight Forwarding',
                'description' => 'Comprehensive solutions for managing and optimizing the process of freight forwarding, including documentation, cargo handling, and customs brokerage.',
                'internal_id' => 'TROFREIGHTFORWARD',
                'icon' => 'truck-ramp-box',
                'tags' => ['freight forwarding', 'cargo handling', 'customs', 'logistics'],
                'for' => 'extension_category'
            ],
            [
                'name' => 'Air Cargo Logistics',
                'description' => 'Specialized tools for air cargo handling, including tracking, capacity management, and air freight optimization.',
                'internal_id' => 'TROAIRCARGO',
                'icon' => 'plane',
                'tags' => ['air cargo', 'tracking', 'capacity management', 'air freight'],
                'for' => 'extension_category'
            ],
            [
                'name' => 'Bulk Shipping',
                'description' => 'Solutions for managing bulk cargo shipments, including vessel chartering, loading and unloading operations, and safety compliance.',
                'internal_id' => 'TROBULKSHIPPING',
                'icon' => 'anchor',
                'tags' => ['bulk shipping', 'vessel chartering', 'cargo operations', 'safety'],
                'for' => 'extension_category'
            ],
            [
                'name' => 'LNG Logistics',
                'description' => 'Tools and technologies for handling Liquefied Natural Gas (LNG) logistics, covering transportation, storage, and distribution.',
                'internal_id' => 'TROLNGLOGISTICS',
                'icon' => 'gas-pump',
                'tags' => ['LNG', 'liquefied natural gas', 'transportation', 'storage'],
                'for' => 'extension_category'
            ],
            [
                'name' => 'Train Cargo Management',
                'description' => 'Systems for managing train cargo logistics, including scheduling, cargo tracking, and railway compliance.',
                'internal_id' => 'TROTRAINCARGO',
                'icon' => 'train',
                'tags' => ['train cargo', 'scheduling', 'tracking', 'railway'],
                'for' => 'extension_category'
            ],
            [
                'name' => 'Container Haulage',
                'description' => 'Efficient management of container haulage operations, with features for container tracking, port operations, and haulier scheduling.',
                'internal_id' => 'TROCONTAINERHAULAGE',
                'icon' => 'trailer',
                'tags' => ['container', 'haulage', 'tracking', 'port operations'],
                'for' => 'extension_category'
            ],
            [
                'name' => 'Tactical Logistics',
                'description' => 'Solutions for tactical support, including field logistics, deployment planning, and military supply chain management.',
                'internal_id' => 'TROTACTICAL',
                'icon' => 'jet-fighter',
                'tags' => ['tactical', 'field logistics', 'deployment', 'military supply'],
                'for' => 'extension_category'
            ],
            [
                'name' => 'Secure Communications',
                'description' => 'Secure and encrypted communication tools designed for military-grade confidentiality and reliability.',
                'internal_id' => 'TROSECURECOMMS',
                'icon' => 'walkie-talkie',
                'tags' => ['secure', 'encrypted', 'communication', 'military'],
                'for' => 'extension_category'
            ],
            [
                'name' => 'Surveillance and Reconnaissance',
                'description' => 'Advanced surveillance and reconnaissance tools, including UAVs, sensors, and satellite imaging for operational intelligence.',
                'internal_id' => 'TROSURVEILLANCE',
                'icon' => 'binoculars',
                'tags' => ['surveillance', 'reconnaissance', 'UAV', 'intelligence'],
                'for' => 'extension_category'
            ],
            [
                'name' => 'Cybersecurity',
                'description' => 'Cybersecurity solutions to protect logistics data and operations from cyber threats and attacks.',
                'internal_id' => 'TROCYBERSECURITY',
                'icon' => 'fingerprint',
                'tags' => ['cybersecurity', 'data protection', 'cyber threats', 'security'],
                'for' => 'extension_category'
            ],
            [
                'name' => 'Mission Planning and Analysis',
                'description' => 'Tools for strategic mission planning and analysis, including scenario modeling and operational readiness assessments.',
                'internal_id' => 'TROMISSIONPLANNING',
                'icon' => 'map-marked-alt',
                'tags' => ['mission planning', 'analysis', 'modeling', 'readiness'],
                'for' => 'extension_category'
            ],
            [
                'name' => 'Armaments and Ammunition Management',
                'description' => 'Management tools for tracking and maintaining armaments and ammunition inventories.',
                'internal_id' => 'TROARMAMANAGEMENT',
                'icon' => 'person-rifle',
                'tags' => ['armaments', 'ammunition', 'inventory', 'management'],
                'for' => 'extension_category'
            ],
            [
                'name' => 'Emergency and Disaster Response',
                'description' => 'Solutions for organizing and managing logistics in emergency and disaster response scenarios.',
                'internal_id' => 'TROEMERGENCYRESPONSE',
                'icon' => 'truck-medical',
                'tags' => ['emergency', 'disaster response', 'logistics', 'crisis management'],
                'for' => 'extension_category'
            ],
            [
                'name' => 'Training and Simulation',
                'description' => 'Advanced training tools and simulation software for military logistics and operational training.',
                'internal_id' => 'TROTRAININGSIM',
                'icon' => 'person-running',
                'tags' => ['training', 'simulation', 'military', 'logistics'],
                'for' => 'extension_category'
            ],
            [
                'name' => 'Vehicle and Equipment Maintenance',
                'description' => 'Maintenance management systems for military vehicles and equipment, including predictive maintenance tools.',
                'internal_id' => 'TROVEHICLEMAINT',
                'icon' => 'wrench',
                'tags' => ['vehicle', 'equipment', 'maintenance', 'predictive tools'],
                'for' => 'extension_category'
            ],
            [
                'name' => 'Manufacturing Operations',
                'description' => 'Tools and systems designed for the manufacturing industry, including automation, process control, and production planning.',
                'internal_id' => 'TROMANUFACTURING',
                'icon' => 'industry',
                'tags' => ['manufacturing', 'automation', 'process control', 'production'],
                'for' => 'extension_category'
            ],
            [
                'name' => 'Medical Logistics',
                'description' => 'Solutions tailored for the medical industry, focusing on medical supply chain, equipment tracking, and pharmaceutical logistics.',
                'internal_id' => 'TROMEDICAL',
                'icon' => 'kit-medical',
                'tags' => ['medical', 'pharmaceutical', 'supply chain', 'equipment tracking'],
                'for' => 'extension_category'
            ],
            [
                'name' => 'Mining Industry',
                'description' => 'Specialized solutions for the mining industry, encompassing resource management, excavation planning, and safety protocols.',
                'internal_id' => 'TROMINING',
                'icon' => 'gem',
                'tags' => ['mining', 'resource management', 'excavation', 'safety'],
                'for' => 'extension_category'
            ]
        ];

        // Insert core extension categories
        foreach ($categories as $category) {
            Category::updateOrCreate(
                [
                    'internal_id' => $category['internal_id'],
                    'for' => 'extension_category'
                ],
                array_merge($category, ['core_category' => 1])
            );
        }
    }
}
