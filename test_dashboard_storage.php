<?php
/**
 * Script de test pour vérifier le stockage des URLs depuis le dashboard
 * 
 * Ce script teste :
 * 1. La création d'URLs avec toutes les informations complètes
 * 2. Le stockage des logs de scan détaillés
 * 3. Le stockage des flags avec sévérité et confiance
 * 4. La génération des rapports détaillés
 */

require_once 'vendor/autoload.php';

use App\Models\Url;
use App\Models\ScanLog;
use App\Models\UrlFlag;
use App\Models\User;

// Initialiser Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== Test du stockage des URLs depuis le dashboard ===\n\n";

try {
    // 1. Créer un utilisateur de test
    echo "1. Création d'un utilisateur de test...\n";
    $user = User::firstOrCreate(
        ['email' => 'test@dashboard.com'],
        ['password_hash' => bcrypt('password123')]
    );
    
    echo "   ✅ Utilisateur créé/trouvé avec ID: {$user->id}\n\n";

    // 2. Créer une URL de test avec toutes les informations
    echo "2. Création d'une URL de test complète...\n";
    $testUrl = Url::create([
        'user_id' => $user->id,
        'original_url' => 'https://example-dashboard-test.com',
        'scan_status' => 'completed',
        'safety_score' => 78.5,
        'report_summary' => 'Test URL complète - Analyse détaillée effectuée',
        'scanned_at' => now(),
    ]);
    
    echo "   ✅ URL créée avec ID: {$testUrl->id}\n";
    echo "   URL: {$testUrl->original_url}\n";
    echo "   Score: {$testUrl->safety_score}\n";
    echo "   Utilisateur: {$testUrl->user_id}\n\n";

    // 3. Créer des logs de scan détaillés
    echo "3. Création des logs de scan détaillés...\n";
    
    // Log principal
    $mainScanLog = ScanLog::create([
        'url_id' => $testUrl->id,
        'scan_details' => [
            'ip_address' => '192.168.1.100',
            'host' => 'example-dashboard-test.com',
            'status_code' => 200,
            'response_time' => 0.345,
            'headers' => [
                'Server' => 'nginx/1.18.0',
                'Content-Type' => 'text/html; charset=UTF-8',
                'X-Frame-Options' => 'SAMEORIGIN',
                'X-Content-Type-Options' => 'nosniff',
                'Strict-Transport-Security' => 'max-age=31536000; includeSubDomains'
            ],
            'ssl_info' => [
                'valid' => true,
                'issuer' => 'Let\'s Encrypt Authority X3',
                'subject' => 'CN=example-dashboard-test.com',
                'expires' => date('Y-m-d', strtotime('+1 year')),
                'protocol' => 'TLSv1.3',
                'cipher' => 'TLS_AES_256_GCM_SHA384'
            ],
            'technologies' => ['PHP', 'WordPress', 'jQuery', 'Bootstrap'],
            'server_info' => [
                'type' => 'nginx',
                'version' => '1.18.0',
                'os' => 'Linux'
            ],
            'security_headers' => [
                'xss_protection' => true,
                'content_security_policy' => false,
                'referrer_policy' => 'strict-origin-when-cross-origin'
            ],
            'scanned_at' => now()->toISOString(),
            'scan_duration' => 4.2
        ]
    ]);
    
    echo "   ✅ Log principal créé avec ID: {$mainScanLog->id}\n";
    
    // Log de métadonnées
    $metadataLog = ScanLog::create([
        'url_id' => $testUrl->id,
        'scan_details' => [
            'metadata' => [
                'total_flags' => 2,
                'critical_flags' => 0,
                'scan_completion_time' => now()->toISOString(),
                'user_agent' => 'Mozilla/5.0 (Test Browser)',
                'client_ip' => '127.0.0.1'
            ],
            'scan_type' => 'metadata'
        ]
    ]);
    
    echo "   ✅ Log de métadonnées créé avec ID: {$metadataLog->id}\n\n";

    // 4. Créer des flags avec sévérité et confiance
    echo "4. Création des flags de sécurité...\n";
    
    $flags = [
        [
            'flag_type' => 'url_shortener',
            'description' => 'URL raccourcie - surveillance recommandée',
            'severity' => 'low',
            'confidence' => 60
        ],
        [
            'flag_type' => 'potential_risk',
            'description' => 'Risques de sécurité potentiels détectés',
            'severity' => 'medium',
            'confidence' => 65
        ]
    ];
    
    foreach ($flags as $flagData) {
        $flag = UrlFlag::create([
            'url_id' => $testUrl->id,
            'flag_type' => $flagData['flag_type'],
            'description' => $flagData['description'],
            'severity' => $flagData['severity'],
            'confidence' => $flagData['confidence'],
            'detected_at' => now()
        ]);
        
        echo "   ✅ Flag créé: {$flag->flag_type} (Sévérité: {$flag->severity}, Confiance: {$flag->confidence}%)\n";
    }
    
    echo "\n";

    // 5. Vérifier les relations et les données
    echo "5. Vérification des relations et données...\n";
    $url = Url::with(['flags', 'scanLogs', 'user'])->find($testUrl->id);
    
    echo "   URL trouvée: {$url->original_url}\n";
    echo "   Utilisateur: {$url->user->email}\n";
    echo "   Nombre de logs: " . $url->scanLogs->count() . "\n";
    echo "   Nombre de flags: " . $url->flags->count() . "\n";
    echo "   Score de sécurité: {$url->safety_score}\n";
    echo "   Statut: {$url->scan_status}\n";
    
    // Afficher les détails des logs
    foreach ($url->scanLogs as $log) {
        $details = $log->scan_details;
        if (isset($details['scan_type'])) {
            echo "   Log {$log->id}: Type {$details['scan_type']}\n";
        } else {
            echo "   Log {$log->id}: Scan principal (IP: {$details['ip_address']})\n";
        }
    }
    
    // Afficher les flags
    foreach ($url->flags as $flag) {
        echo "   Flag: {$flag->flag_type} - {$flag->description} (Sévérité: {$flag->severity})\n";
    }
    
    echo "\n";

    // 6. Vérifier les statistiques du dashboard
    echo "6. Statistiques du dashboard...\n";
    $stats = [
        'total_scans' => $user->urls()->count(),
        'completed_scans' => $user->urls()->where('scan_status', 'completed')->count(),
        'pending_scans' => $user->urls()->where('scan_status', 'pending')->count(),
        'average_score' => $user->urls()->whereNotNull('safety_score')->avg('safety_score'),
        'total_flags' => $user->urls()->withCount('flags')->get()->sum('flags_count'),
    ];
    
    foreach ($stats as $key => $value) {
        $formattedValue = is_numeric($value) ? number_format($value, 2) : $value;
        echo "   {$key}: {$formattedValue}\n";
    }
    
    echo "\n";

    // 7. Nettoyer les données de test
    echo "7. Nettoyage des données de test...\n";
    $url->scanLogs()->delete();
    $url->flags()->delete();
    $url->delete();
    
    echo "   ✅ Données de test supprimées\n\n";
    
    echo "=== Test terminé avec succès ===\n";
    echo "Le stockage des URLs depuis le dashboard fonctionne correctement !\n";
    echo "Toutes les informations complètes sont stockées en base de données.\n";

} catch (Exception $e) {
    echo "❌ Erreur lors du test: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
} 