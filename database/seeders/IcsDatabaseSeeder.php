<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Reservation;
use App\Models\ActivityLog;
use App\Models\SystemUser;
use App\Models\SupportTicket;
use App\Models\SupportMessage;

class IcsDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Initial Products
        $products = [
            [
                'item_code' => 'ICS-POLO-M',
                'name' => 'Official Male Collegiate Polo Barong',
                'category' => 'general',
                'dept' => 'all',
                'gender' => 'Male',
                'price' => 420.00,
                'description' => 'Crisp, lightweight premium linen-cotton polo barong with tailored navy piping on collar and embroidered ICS heraldry on the left chest.',
                'material' => 'Linen-Cotton Twill Blend (Anti-Wrinkle)',
                'image_path' => 'images/male_polo.jpg',
                'sizes' => ['XS' => 8, 'S' => 18, 'M' => 28, 'L' => 20, 'XL' => 10, '2XL' => 4, '3XL' => 1],
                'initial_stock' => 120,
                'current_stock' => 89,
                'units_sold' => 21,
                'units_reserved' => 10,
                'is_active' => true,
            ],
            [
                'item_code' => 'ICS-BLOUSE-F',
                'name' => 'Official Female Tailored Blouse with Ribbon',
                'category' => 'general',
                'dept' => 'all',
                'gender' => 'Female',
                'price' => 390.00,
                'description' => 'Form-fitting tailored white collegiate uniform blouse with detachable navy satin neck ribbon and embroidered ICS organization seal.',
                'material' => 'Fine Tetoron Cotton (Breathable)',
                'image_path' => 'images/female_blouse.jpg',
                'sizes' => ['XS' => 12, 'S' => 24, 'M' => 32, 'L' => 25, 'XL' => 12, '2XL' => 5, '3XL' => 2],
                'initial_stock' => 150,
                'current_stock' => 112,
                'units_sold' => 26,
                'units_reserved' => 12,
                'is_active' => true,
            ],
            [
                'item_code' => 'ICS-SLACKS-M',
                'name' => 'Official Male Formal Tailored Slacks',
                'category' => 'general',
                'dept' => 'all',
                'gender' => 'Male',
                'price' => 450.00,
                'description' => 'Slim-straight cut deep navy formal dress trousers with reinforced belt loops and center press line. Matches ICS uniform guidelines.',
                'material' => 'Gabardine Wool Blend (Formal Finish)',
                'image_path' => 'images/male_slacks.jpg',
                'sizes' => ['XS' => 6, 'S' => 14, 'M' => 26, 'L' => 18, 'XL' => 8, '2XL' => 3, '3XL' => 0],
                'initial_stock' => 100,
                'current_stock' => 75,
                'units_sold' => 18,
                'units_reserved' => 7,
                'is_active' => true,
            ],
            [
                'item_code' => 'ICS-SKIRT-F',
                'name' => 'Official Female Pleated A-Line Skirt',
                'category' => 'general',
                'dept' => 'all',
                'gender' => 'Female',
                'price' => 420.00,
                'description' => 'Knee-length A-line pleated skirt in royal collegiate navy with gold crest embroidery and concealed side zipper with secure pocket.',
                'material' => 'High-Density Poly-Viscose Pleated Fabric',
                'image_path' => 'images/female_skirt.jpg',
                'sizes' => ['XS' => 9, 'S' => 20, 'M' => 30, 'L' => 22, 'XL' => 9, '2XL' => 2, '3XL' => 0],
                'initial_stock' => 120,
                'current_stock' => 92,
                'units_sold' => 20,
                'units_reserved' => 8,
                'is_active' => true,
            ],
            [
                'item_code' => 'ICS-PE-SHIRT',
                'name' => 'ICS Athletics PE Dry-Fit Shirt',
                'category' => 'pe',
                'dept' => 'all',
                'gender' => 'Unisex',
                'price' => 320.00,
                'description' => 'Performance-grade crimson and golden yellow athletic moisture-wicking jersey featuring bold ICS Society chest insignia.',
                'material' => 'Micro-Mesh CoolDry Polyester',
                'image_path' => 'images/pe_shirt.jpg',
                'sizes' => ['XS' => 20, 'S' => 35, 'M' => 50, 'L' => 40, 'XL' => 22, '2XL' => 10, '3XL' => 5],
                'initial_stock' => 250,
                'current_stock' => 182,
                'units_sold' => 52,
                'units_reserved' => 16,
                'is_active' => true,
            ],
            [
                'item_code' => 'ICS-PE-PANTS',
                'name' => 'ICS Athletics PE Track Jogger Pants',
                'category' => 'pe',
                'dept' => 'all',
                'gender' => 'Unisex',
                'price' => 380.00,
                'description' => 'Tapered sports joggers with bold collegiate gold double side stripes, comfortable elastic drawstring waistband, and zippered pockets.',
                'material' => 'Heavyweight Poly-Cotton French Terry',
                'image_path' => 'images/pe_pants.jpg',
                'sizes' => ['XS' => 15, 'S' => 28, 'M' => 42, 'L' => 30, 'XL' => 15, '2XL' => 6, '3XL' => 3],
                'initial_stock' => 180,
                'current_stock' => 139,
                'units_sold' => 31,
                'units_reserved' => 10,
                'is_active' => true,
            ],
            [
                'item_code' => 'ICS-VARSITY',
                'name' => 'Collegiate Letterman Varsity Bomber Jacket',
                'category' => 'department',
                'dept' => 'all',
                'gender' => 'Unisex',
                'price' => 780.00,
                'description' => 'Premium heavyweight ICS varsity letterman jacket with genuine leather-feel sleeves, chenille collegiate crest, and thermal diamond quilt lining.',
                'material' => 'Melton Wool Body & Vegan Leather Sleeves',
                'image_path' => 'images/varsity_jacket.jpg',
                'sizes' => ['XS' => 5, 'S' => 12, 'M' => 18, 'L' => 14, 'XL' => 8, '2XL' => 3, '3XL' => 1],
                'initial_stock' => 80,
                'current_stock' => 61,
                'units_sold' => 14,
                'units_reserved' => 5,
                'is_active' => true,
            ],
            [
                'item_code' => 'ICS-DEPT-TECH',
                'name' => 'CICS Tech Vanguard Department Polo',
                'category' => 'department',
                'dept' => 'CICS',
                'gender' => 'Unisex',
                'price' => 360.00,
                'description' => 'Midnight slate departmental collared shirt with neon cyan piping and embroidered Computer Science & Information Systems emblem.',
                'material' => 'Honeycomb Pique Cotton (230 GSM)',
                'image_path' => 'images/dept_tech.jpg',
                'sizes' => ['XS' => 6, 'S' => 16, 'M' => 24, 'L' => 18, 'XL' => 7, '2XL' => 2, '3XL' => 0],
                'initial_stock' => 95,
                'current_stock' => 73,
                'units_sold' => 17,
                'units_reserved' => 5,
                'is_active' => true,
            ],
            [
                'item_code' => 'ICS-DEPT-BA',
                'name' => 'CBAA Corporate Executive Department Polo',
                'category' => 'department',
                'dept' => 'CBAA',
                'gender' => 'Unisex',
                'price' => 360.00,
                'description' => 'Rich burgundy corporate polo with metallic gold embroidery representing Business Administration and Accountancy students.',
                'material' => '100% Combed Compact Cotton',
                'image_path' => 'images/dept_ba.jpg',
                'sizes' => ['XS' => 4, 'S' => 14, 'M' => 20, 'L' => 15, 'XL' => 6, '2XL' => 1, '3XL' => 0],
                'initial_stock' => 85,
                'current_stock' => 60,
                'units_sold' => 18,
                'units_reserved' => 7,
                'is_active' => true,
            ],
            [
                'item_code' => 'ICS-LANYARD',
                'name' => 'Official ICS Gold-Foil Lanyard & Case',
                'category' => 'accessory',
                'dept' => 'all',
                'gender' => 'Unisex',
                'price' => 95.00,
                'description' => 'Heavy satin crimson and gold ribbon with metallic ICS 2026-2027 lettering, durable metal swivel clasp, and crystal-clear polycarbonate ID card holder.',
                'material' => 'Sublimated Satin & Reinforced Alloy Clip',
                'image_path' => 'images/lanyard.jpg',
                'sizes' => ['Standard' => 120],
                'initial_stock' => 300,
                'current_stock' => 120,
                'units_sold' => 155,
                'units_reserved' => 25,
                'is_active' => true,
            ],
        ];

        foreach ($products as $p) {
            Product::updateOrCreate(['item_code' => $p['item_code']], $p);
        }

        // 2. Initial Reservations
        $reservations = [
            [
                'ref_code' => 'ICS-2026-X941K',
                'student_name' => 'Julian Angelo Santos',
                'student_id' => '2024-10822-AIS',
                'department' => 'Associate in Information Systems (AIS)',
                'year_level' => '2nd Year',
                'contact' => '09178239012',
                'pickup_date' => '2026-10-08',
                'pickup_slot' => '10:30 AM - 12:30 PM (Batch 2 Midday)',
                'items' => [
                    ['productId' => 'ICS-POLO-M', 'productName' => 'Official Male Collegiate Polo Barong', 'size' => 'L', 'quantity' => 2, 'price' => 420, 'imageSrc' => 'images/male_polo.jpg'],
                    ['productId' => 'ICS-SLACKS-M', 'productName' => 'Official Male Formal Tailored Slacks', 'size' => 'L', 'quantity' => 1, 'price' => 450, 'imageSrc' => 'images/male_slacks.jpg'],
                    ['productId' => 'ICS-LANYARD', 'productName' => 'Official ICS Gold-Foil Lanyard & Case', 'size' => 'Standard', 'quantity' => 1, 'price' => 95, 'imageSrc' => 'images/lanyard.jpg'],
                ],
                'total_amount' => 1385.00,
                'status' => 'Ready for Pickup',
                'notes' => 'Paid via student advance clearance / Cash on pickup',
            ],
            [
                'ref_code' => 'ICS-2026-W379P',
                'student_name' => 'Samantha Nicole Reyes',
                'student_id' => '2023-08451-BSIS',
                'department' => 'Bachelor of Science in Information Systems (BSIS)',
                'year_level' => '3rd Year',
                'contact' => '09285512940',
                'pickup_date' => '2026-10-09',
                'pickup_slot' => '01:30 PM - 03:30 PM (Batch 3 Afternoon)',
                'items' => [
                    ['productId' => 'ICS-BLOUSE-F', 'productName' => 'Official Female Tailored Blouse with Ribbon', 'size' => 'M', 'quantity' => 2, 'price' => 390, 'imageSrc' => 'images/female_blouse.jpg'],
                    ['productId' => 'ICS-SKIRT-F', 'productName' => 'Official Female Pleated A-Line Skirt', 'size' => 'M', 'quantity' => 1, 'price' => 420, 'imageSrc' => 'images/female_skirt.jpg'],
                ],
                'total_amount' => 1200.00,
                'status' => 'Pending',
                'notes' => 'Pre-ordered for midterm uniform compliance',
            ],
            [
                'ref_code' => 'ICS-2026-M512Q',
                'student_name' => 'Christian David Mendoza',
                'student_id' => '2025-01429-AIS',
                'department' => 'Associate in Information Systems (AIS)',
                'year_level' => '1st Year',
                'contact' => '09951234881',
                'pickup_date' => '2026-10-07',
                'pickup_slot' => '08:30 AM - 10:30 AM (Batch 1 Morning)',
                'items' => [
                    ['productId' => 'ICS-PE-SHIRT', 'productName' => 'ICS Athletics PE Dry-Fit Shirt', 'size' => 'XL', 'quantity' => 1, 'price' => 320, 'imageSrc' => 'images/pe_shirt.jpg'],
                    ['productId' => 'ICS-PE-PANTS', 'productName' => 'ICS Athletics PE Track Jogger Pants', 'size' => 'XL', 'quantity' => 1, 'price' => 380, 'imageSrc' => 'images/pe_pants.jpg'],
                ],
                'total_amount' => 700.00,
                'status' => 'Claimed',
                'notes' => 'Claimed and verified at ICS Student Council Center',
            ],
        ];

        foreach ($reservations as $r) {
            Reservation::updateOrCreate(['ref_code' => $r['ref_code']], $r);
        }

        // 3. System Users (Honoring Whiteboard & Class Roster)
        $users = [
            [
                'user_code' => 'USR-001',
                'name' => 'E. Moreno',
                'email' => 'e.moreno@gmail.com',
                'role' => 'Admin (Faculty Adviser)',
                'department' => 'Integrated Computer Society',
                'status' => 'Active',
            ],
            [
                'user_code' => 'USR-002',
                'name' => 'J. Derramas',
                'email' => 'j.derramas@ics.edu.ph',
                'role' => 'Team Lead / Core Admin',
                'department' => 'AIS 2B - CP3 Group 4',
                'status' => 'Active',
            ],
            [
                'user_code' => 'USR-003',
                'name' => 'Buenaventura',
                'email' => 'buenaventura@ics.edu.ph',
                'role' => 'Backend & Logic Lead',
                'department' => 'AIS 2B - CP3 Group 4',
                'status' => 'Active',
            ],
            [
                'user_code' => 'USR-004',
                'name' => 'Regadio',
                'email' => 'regadio@ics.edu.ph',
                'role' => 'Frontend & UI Specialist',
                'department' => 'AIS 2B - CP3 Group 4',
                'status' => 'Active',
            ],
            [
                'user_code' => 'USR-005',
                'name' => 'Dotillos',
                'email' => 'dotillos@ics.edu.ph',
                'role' => 'Database Administrator',
                'department' => 'AIS 2B - CP3 Group 4',
                'status' => 'Active',
            ],
            [
                'user_code' => 'USR-006',
                'name' => 'Albor',
                'email' => 'albor@ics.edu.ph',
                'role' => 'System Support & Docs',
                'department' => 'AIS 2B - CP3 Group 4',
                'status' => 'Active',
            ],
            [
                'user_code' => 'USR-007',
                'name' => 'Julian Angelo Santos',
                'email' => 'julian.santos@student.edu.ph',
                'role' => 'Student Member',
                'department' => 'Associate in Information Systems (AIS)',
                'status' => 'Active',
            ],
        ];

        foreach ($users as $u) {
            SystemUser::updateOrCreate(['user_code' => $u['user_code']], $u);
        }

        // 4. Activity Logs (Audit Trail matching Whiteboard Schema)
        $logs = [
            [
                'user_code' => 'USR-001',
                'user_name' => 'E. Moreno',
                'action' => 'LOGIN',
                'activity' => 'User logged in to ICS Admin Portal',
                'module' => 'Authentication',
                'created_at' => now()->subHours(8),
            ],
            [
                'user_code' => 'USR-001',
                'user_name' => 'E. Moreno',
                'action' => 'READ',
                'activity' => 'Generated Sales vs Stock Comprehensive Merch Report',
                'module' => 'Reports',
                'created_at' => now()->subHours(6),
            ],
            [
                'user_code' => 'USR-002',
                'user_name' => 'J. Derramas',
                'action' => 'CREATE',
                'activity' => 'Added new apparel item: ICS Varsity Bomber Jacket (Melton Wool)',
                'module' => 'Information Management',
                'created_at' => now()->subHours(4),
            ],
            [
                'user_code' => 'USR-002',
                'user_name' => 'J. Derramas',
                'action' => 'UPDATE',
                'activity' => 'Uploaded new high-definition photo for Male Polo Barong',
                'module' => 'Information Management',
                'created_at' => now()->subHours(3),
            ],
            [
                'user_code' => 'USR-003',
                'user_name' => 'Buenaventura',
                'action' => 'UPDATE',
                'activity' => 'Marked reservation ICS-2026-X941K as Ready for Pickup',
                'module' => 'Reservation Logistics',
                'created_at' => now()->subHours(2),
            ],
            [
                'user_code' => 'USR-004',
                'user_name' => 'Regadio',
                'action' => 'UPDATE',
                'activity' => 'Adjusted stock levels for ICS Athletics PE Dry-Fit Shirt (+50 units)',
                'module' => 'Information Management',
                'created_at' => now()->subHour(),
            ],
            [
                'user_code' => 'USR-001',
                'user_name' => 'E. Moreno',
                'action' => 'LOGOUT',
                'activity' => 'User session logged out cleanly',
                'module' => 'Authentication',
                'created_at' => now()->subMinutes(20),
            ],
        ];

        foreach ($logs as $l) {
            ActivityLog::create($l);
        }

        // 5. Initial Support Helpdesk Tickets & Messages
        if (SupportTicket::count() === 0) {
            $t1 = SupportTicket::create([
                'ticket_code' => 'TCK-2026-0001',
                'student_id' => '2025-01429-AIS',
                'student_name' => 'Julian Angelo Santos',
                'department' => 'Associate in Information Systems (AIS)',
                'reservation_ref' => 'ICS-2026-CUTY3',
                'reason' => 'Cancel Reservation',
                'subject' => 'Request to cancel uniform reservation',
                'status' => 'In Progress',
                'priority' => 'Urgent',
            ]);

            SupportMessage::create([
                'ticket_id' => $t1->id,
                'sender_type' => 'student',
                'sender_name' => 'Julian Angelo Santos',
                'sender_id' => '2025-01429-AIS',
                'message' => 'Hi Admin! I mistakenly submitted a duplicate reservation for the Male Polo Barong. Can I please cancel reservation ICS-2026-CUTY3? Thank you!',
            ]);

            SupportMessage::create([
                'ticket_id' => $t1->id,
                'sender_type' => 'admin',
                'sender_name' => 'ICS Admin Support',
                'sender_id' => 'USR-001',
                'message' => 'Hello Julian! We received your ticket request. We are reviewing your order and can approve the cancellation for you shortly.',
            ]);

            $t2 = SupportTicket::create([
                'ticket_code' => 'TCK-2026-0002',
                'student_id' => '2023-08451-BSIS',
                'student_name' => 'Samantha Nicole Reyes',
                'department' => 'BS in Information Systems',
                'reservation_ref' => 'ICS-2026-W379P',
                'reason' => 'Change Item Size',
                'subject' => 'Size adjustment for Female Blouse',
                'status' => 'Open',
                'priority' => 'Normal',
            ]);

            SupportMessage::create([
                'ticket_id' => $t2->id,
                'sender_type' => 'student',
                'sender_name' => 'Samantha Nicole Reyes',
                'sender_id' => '2023-08451-BSIS',
                'message' => 'Good day Admin, can I request to change the blouse size from Medium to Large before pickup on Friday? Thanks!',
            ]);
        }
    }
}
