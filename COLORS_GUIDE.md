# Guide des Couleurs SafeScanner

## Palette de Couleurs Personnalisées

L'application SafeScanner utilise maintenant une palette de couleurs verte moderne et cohérente :

### Couleurs Principales

1. **Vert Clair** - `#21F4B`
   - Utilisé pour : Liens, boutons principaux, éléments d'accent
   - Classe CSS : `.text-primary`, `.bg-primary`, `.border-primary`

2. **Vert Moyen** - `#16C172`
   - Utilisé pour : Gradients, effets de survol, éléments secondaires
   - Classe CSS : `.text-secondary`, `.bg-secondary`, `.border-secondary`

3. **Vert Vif** - `#09E85E`
   - Utilisé pour : Accents, animations, éléments interactifs
   - Classe CSS : `.text-accent`, `.bg-accent`, `.border-accent`

4. **Vert Néon** - `#2AFC98`
   - Utilisé pour : Effets spéciaux, highlights, éléments de pointe
   - Classe CSS : `.text-neon`, `.bg-neon`, `.border-neon`

### Utilisation dans l'Application

#### Pages Modifiées
- ✅ **Page d'accueil** (`welcome.blade.php`)
- ✅ **Dashboard** (`dashboard.blade.php`)
- ✅ **Connexion** (`login.blade.php`)
- ✅ **Inscription** (`register.blade.php`)

#### Éléments Mis à Jour
- Arrière-plans animés avec les nouvelles couleurs
- Boutons et liens avec gradients personnalisés
- Particules flottantes avec la nouvelle palette
- Icônes et logos avec les nouvelles couleurs
- États de focus et de survol
- Messages de statut et alertes
- Indicateurs de force de mot de passe

### Classes CSS Utilitaires

#### Couleurs de Texte
```css
.text-primary    /* #21F4B */
.text-secondary  /* #16C172 */
.text-accent     /* #09E85E */
.text-neon       /* #2AFC98 */
```

#### Couleurs d'Arrière-plan
```css
.bg-primary      /* #21F4B */
.bg-secondary    /* #16C172 */
.bg-accent       /* #09E85E */
.bg-neon         /* #2AFC98 */
```

#### Bordures
```css
.border-primary  /* #21F4B */
.border-secondary /* #16C172 */
.border-accent   /* #09E85E */
.border-neon     /* #2AFC98 */
```

#### Gradients
```css
.gradient-primary  /* #21F4B → #16C172 */
.gradient-accent   /* #09E85E → #2AFC98 */
.gradient-full     /* Toutes les couleurs */
```

#### Boutons Personnalisés
```css
.btn-custom-primary  /* Gradient primaire avec effets */
.btn-custom-accent   /* Gradient accent avec effets */
```

#### Cartes avec Bordures Colorées
```css
.card-primary    /* Bordure gauche #21F4B */
.card-secondary  /* Bordure gauche #16C172 */
.card-accent     /* Bordure gauche #09E85E */
.card-neon       /* Bordure gauche #2AFC98 */
```

#### Animations
```css
.glow-primary    /* Animation de lueur avec #21F4B */
.glow-accent     /* Animation de lueur avec #09E85E */
```

### Variables CSS

Toutes les couleurs sont définies comme variables CSS dans `resources/css/custom-colors.css` :

```css
:root {
    --color-primary: #21F4B;
    --color-secondary: #16C172;
    --color-accent: #09E85E;
    --color-neon: #2AFC98;
    
    /* Variations avec transparence */
    --color-primary-20: rgba(33, 244, 187, 0.2);
    --color-primary-30: rgba(33, 244, 187, 0.3);
    --color-primary-50: rgba(33, 244, 187, 0.5);
    /* ... etc pour toutes les couleurs */
}
```

### Cohérence Visuelle

La nouvelle palette assure une cohérence visuelle à travers toute l'application :
- **Navigation** : Utilise principalement le vert clair (#21F4B)
- **Actions principales** : Gradients du vert clair au vert moyen
- **Accents** : Vert vif (#09E85E) pour les éléments interactifs
- **Effets spéciaux** : Vert néon (#2AFC98) pour les highlights

### Maintenance

Pour modifier les couleurs à l'avenir :
1. Modifier les variables CSS dans `resources/css/custom-colors.css`
2. Les changements s'appliqueront automatiquement à toute l'application
3. Utiliser les classes utilitaires pour de nouveaux éléments

---

*Dernière mise à jour : Application des 4 couleurs vertes personnalisées*
