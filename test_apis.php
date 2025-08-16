<?php

/**
 * Script de test rapide pour vérifier les APIs
 * Usage: php test_apis.php
 */

require_once 'vendor/autoload.php';

// Charger l'environnement Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Services\UrlIntelService;

echo "🧪 Test des APIs SafeScanner\n";
// echo "=============================\n\n";

// Vérifier la configuration
echo "1. Vérification de la configuration...\n";
$virusTotalKey = config('services.virustotal.api_key');
$openAiKey = config('services.openai.api_key');

echo "   VirusTotal API Key: " . ($virusTotalKey ? "✅ Configurée" : "❌ Non configurée") . "\n";
echo "   OpenAI API Key: " . ($openAiKey ? "✅ Configurée" : "❌ Non configurée") . "\n\n";

if (!$virusTotalKey || !$openAiKey) {
    echo "⚠️  Veuillez configurer les clés API dans le fichier .env\n";
    echo "   VIRUSTOTAL_API_KEY=votre_clé_virustotal\n";
    echo "   OPENAI_API_KEY=votre_clé_openai\n\n";
    exit(1);
}

// Tester VirusTotal
echo "2. Test VirusTotal...\n";
try {
    $urlIntelService = new UrlIntelService();
    $result = $urlIntelService->scanWithVirusTotal('https://google.com');
    
    if (isset($result['success']) && $result['success']) {
        echo "   VirusTotal fonctionne\n";
        echo "   Résultats: " . json_encode($result['data'], JSON_PRETTY_PRINT) . "\n\n";
    } else {
        echo "   ❌ VirusTotal erreur: " . ($result['error'] ?? 'Erreur inconnue') . "\n\n";
    }
} catch (Exception $e) {
    echo "   ❌ VirusTotal exception: " . $e->getMessage() . "\n\n";
}

// Tester OpenAI
echo "3. Test OpenAI...\n";
try {
    $internalScan = [
        'safety_score' => 75,
        'threats' => [
            [
                'type' => 'phishing',
                'description' => 'Test threat for verification'
            ]
        ]
    ];
    
    $virusTotalData = [
        'data' => [
            'positives' => 2,
            'total_scanners' => 70,
            'detection_rate' => 2.8
        ]
    ];
    
    $report = $urlIntelService->generateAiReport($internalScan, $virusTotalData);
    
    if ($report && strlen($report) > 50) {
        echo "    OpenAI fonctionne\n";
        echo "    Rapport généré:\n";
        echo "   " . str_replace("\n", "\n   ", $report) . "\n\n";
    } else {
        echo "   ❌ OpenAI: Rapport vide ou erreur\n\n";
    }
} catch (Exception $e) {
    echo "   ❌ OpenAI exception: " . $e->getMessage() . "\n\n";
}

// Test complet
echo "4. Test complet...\n";
try {
    $comprehensiveResult = $urlIntelService->getComprehensiveAnalysis(
        'https://google.com',
        [
            [
                'type' => 'test_threat',
                'description' => 'Test threat for comprehensive analysis'
            ]
        ]
    );
    
    if (isset($comprehensiveResult['comprehensive_report'])) {
        echo "   Analyse complète fonctionne\n";
        echo "   Niveau de risque: " . ($comprehensiveResult['risk_level'] ?? 'N/A') . "\n";
        echo "   Score interne: " . ($comprehensiveResult['internal_scan']['safety_score'] ?? 'N/A') . "\n\n";
    } else {
        echo "   ❌ Analyse complète: Erreur\n\n";
    }
} catch (Exception $e) {
    echo "   ❌ Analyse complète exception: " . $e->getMessage() . "\n\n";
}

