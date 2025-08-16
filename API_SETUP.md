# Configuration des APIs - SafeScanner

## 🔧 Configuration requise

### 1. VirusTotal API

1. **Obtenir une clé API** :
   - Allez sur [VirusTotal](https://www.virustotal.com/)
   - Créez un compte gratuit
   - Accédez à votre profil et générez une clé API

2. **Configuration** :
   ```bash
   # Ajoutez dans votre fichier .env
   VIRUSTOTAL_API_KEY=votre_clé_api_virustotal
   ```

### 2. OpenAI API

1. **Obtenir une clé API** :
   - Allez sur [OpenAI Platform](https://platform.openai.com/)
   - Créez un compte
   - Générez une clé API dans la section "API Keys"

2. **Configuration** :
   ```bash
   # Ajoutez dans votre fichier .env
   OPENAI_API_KEY=votre_clé_api_openai
   ```

## 🚀 Fonctionnalités intégrées

### VirusTotal Integration
- **Scan d'URLs** : Analyse complète avec 70+ moteurs antivirus
- **Détection de menaces** : Malware, phishing, spam, etc.
- **Taux de détection** : Pourcentage de scanners qui détectent des menaces
- **Historique** : Données de scan stockées localement

### OpenAI Integration
- **Rapports intelligents** : Génération automatique de rapports en français
- **Analyse contextuelle** : Combinaison des résultats internes + VirusTotal
- **Recommandations** : Conseils personnalisés selon le niveau de risque
- **Fallback** : Rapport basique si l'API n'est pas disponible

## 📊 Processus de scan amélioré

1. **Scan interne** : Analyse locale des patterns suspects
2. **VirusTotal** : Vérification avec 70+ moteurs antivirus
3. **IA OpenAI** : Génération de rapport intelligent
4. **Score combiné** : Calcul final intégrant toutes les sources

## 🔒 Sécurité

- **Clés API sécurisées** : Stockage dans les variables d'environnement
- **Logs d'erreurs** : Traçabilité complète des appels API
- **Fallback robuste** : Fonctionnement même sans APIs externes
- **Rate limiting** : Respect des limites d'API

## 💡 Utilisation

Le service `UrlIntelService` est automatiquement injecté dans les contrôleurs :

```php
// Dans UrlController et HomeController
private $urlIntelService;

public function __construct(UrlIntelService $urlIntelService)
{
    $this->urlIntelService = $urlIntelService;
}
```

## 🎯 Avantages

- **Analyse complète** : Interne + VirusTotal + IA
- **Rapports intelligents** : Génération automatique en français
- **Score précis** : Combinaison de multiples sources
- **Extensible** : Facile d'ajouter d'autres APIs
- **Robuste** : Fonctionne même sans APIs externes 