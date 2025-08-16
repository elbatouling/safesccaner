# 🔍 Guide de Vérification des APIs

## 🎯 Comment vérifier que les APIs fonctionnent

### 1. **Accéder à la page de test**
```
http://127.0.0.1:8000/test/apis
```

### 2. **Vérifier la configuration**
- Cliquez sur "Vérifier la configuration"
- Vérifiez que les clés API sont configurées :
  - ✅ **VIRUSTOTAL_API_KEY** : "Configured"
  - ✅ **OPENAI_API_KEY** : "Configured"

### 3. **Test VirusTotal**
- Entrez une URL (ex: `https://google.com`)
- Cliquez sur "Tester VirusTotal"
- **Résultat attendu** :
  ```json
  {
    "success": true,
    "data": {
      "positives": 0,
      "total_scanners": 70,
      "detection_rate": 0,
      "detected_threats": [],
      "scan_date": "2024-01-01T12:00:00Z"
    }
  }
  ```

### 4. **Test OpenAI**
- Entrez des données de test dans les champs JSON
- Cliquez sur "Tester OpenAI"
- **Résultat attendu** :
  ```
  ✅ OpenAI - Rapport généré
  
  Rapport de sécurité généré le 01/01/2024 12:00
  
  Score de sécurité interne: 75/100
  Menaces détectées: 1
  
  Menaces identifiées:
  - phishing: Test threat
  
  Analyse VirusTotal:
  - 2 scanners sur 70 ont détecté des menaces
  - Taux de détection: 2.8%
  
  Niveau de risque: MODÉRÉ
  
  Recommandations:
  - Prudence recommandée - Vérifier avant utilisation
  ```

### 5. **Test complet**
- Entrez une URL
- Cliquez sur "Test complet"
- **Résultat attendu** : Analyse combinant VirusTotal + OpenAI

## 🔧 Configuration des clés API

### VirusTotal API
1. Allez sur [VirusTotal](https://www.virustotal.com/)
2. Créez un compte gratuit
3. Générez une clé API dans votre profil
4. Ajoutez dans votre `.env` :
   ```
   VIRUSTOTAL_API_KEY=votre_clé_api_virustotal
   ```

### OpenAI API
1. Allez sur [OpenAI Platform](https://platform.openai.com/)
2. Créez un compte
3. Générez une clé API
4. Ajoutez dans votre `.env` :
   ```
   OPENAI_API_KEY=votre_clé_api_openai
   ```

## 🚨 Problèmes courants

### VirusTotal ne fonctionne pas
- **Erreur** : "Failed to submit URL to VirusTotal"
- **Solution** : Vérifiez votre clé API VirusTotal
- **Limite** : 4 requêtes/minute en version gratuite

### OpenAI ne fonctionne pas
- **Erreur** : "OpenAI API error"
- **Solution** : Vérifiez votre clé API OpenAI
- **Limite** : Consommation de tokens selon votre plan

### Erreur de configuration
- **Erreur** : "Not configured"
- **Solution** : Ajoutez les clés API dans le fichier `.env`

## 📊 Indicateurs de succès

### ✅ VirusTotal fonctionne si :
- Réponse avec `"success": true`
- Données de scan complètes
- Taux de détection calculé

### ✅ OpenAI fonctionne si :
- Rapport généré en français
- Analyse contextuelle
- Recommandations personnalisées

### ✅ Intégration complète si :
- Score combiné calculé
- Rapport intelligent généré
- Données stockées en base

## 🔍 Vérification dans les logs

Vérifiez les logs Laravel pour les détails :
```bash
tail -f storage/logs/laravel.log
```

## 🎯 Test en production

1. **Testez avec des URLs réelles** :
   - `https://google.com` (sûr)
   - `https://example.com` (sûr)
   - URLs suspectes pour tester la détection

2. **Vérifiez les scores** :
   - URLs sûres : 80-100
   - URLs suspectes : 50-80
   - URLs dangereuses : 0-50

3. **Vérifiez les rapports** :
   - Génération automatique
   - Langue française
   - Recommandations pertinentes

## 🚀 Amélioration continue

- **Ajoutez d'autres APIs** : AbuseIPDB, URLVoid, etc.
- **Optimisez les prompts** : Améliorez les rapports OpenAI
- **Cache les résultats** : Évitez les scans répétés
- **Notifications** : Alertes pour menaces critiques 