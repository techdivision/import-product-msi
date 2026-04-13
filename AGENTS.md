# AGENTS.md - import-product-msi

## Zweck & Verantwortung

Das `import-product-msi` Modul bietet **Magento MSI (Multi-Source Inventory) Import-Funktionalität**. Es ist ein **Tier 5 Modul** und erweitert `import-product`.

**Hauptverantwortung:**
- MSI Source Item Import
- Stock Level Management
- Repository Pattern für MSI-Daten
- Service Layer für MSI-Verarbeitung
- Observer Pattern für MSI-Hooks

## Architektur & Design Patterns

### Kern-Klassen
- **MsiSourceItemRepository**: Persistierung von Source Items
- **MsiStockRepository**: Persistierung von Stock Levels
- **MsiProcessor**: Service Layer
- **MsiObserver**: Observer für Hooks

### Verwendete Patterns
- **Observer Pattern**: Für MSI-Hooks
- **Repository Pattern**: Für Daten-Persistierung
- **Service Layer**: Für Business Logic

## Abhängigkeiten

### Externe Pakete
- **Keine**

### TechDivision Dependencies
- **import-product** ^26.2 - Product Importer

### Abhängig von diesem Modul (1 Reverse Dependency)
- **import-cli-simple** - Master CLI

## Wichtige Entry Points

### Repository Klassen
```php
// MSI Source Item Repository
MsiSourceItemRepository::create($row): void
MsiSourceItemRepository::findByProductId($productId): array

// MSI Stock Repository
MsiStockRepository::create($row): void
```

## Events & Extension Points

**Keine Events** - Tier 5 Importer-Modul

## Hints für KI-Agenten

### Wichtig zu verstehen
1. **Tier 5 Modul**: Erweitert Product Importer
2. **MSI-fokussiert**: Spezialisiert auf Multi-Source Inventory
3. **Observer Pattern**: Für Hooks
4. **Repository Pattern**: Für Persistierung

## Bekannte Einschränkungen

- **MSI-Only**: Keine anderen Inventory-Features
- **Abhängig von Products**: Erfordert Products zu existieren
- **Magento 2.3+**: Erfordert MSI-Module

## Zusammenfassung

`import-product-msi` ist ein **Tier 5 Modul**, das Magento MSI Import-Funktionalität bietet. Es erweitert den Product Importer mit spezialisierter Funktionalität für Multi-Source Inventory.

**Für Agenten:** Verstehe dieses Modul als **MSI Importer** mit Observer und Repository Pattern.
