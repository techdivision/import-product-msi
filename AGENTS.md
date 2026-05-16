# AGENTS.md - import-product-msi

## Zweck & Verantwortung

Das `import-product-msi` Modul bietet **Multi-Source Inventory (MSI) Import-Funktionalität** für dezentrales Inventory Management. Es ist ein **Tier 5 Modul** in der Import-Architektur und erweitert das `import-product` Modul mit spezialisierten Funktionen für Multi-Source Stock-Management.

**Hauptverantwortung:**
- Multi-Source Inventory Import
- Source Stock Management und Quantity Handling
- Stock Status Management (In Stock / Out of Stock)
- Source-spezifische Availability Tracking
- Saleable Quantity Calculation
- Source Validation und Mapping

**Modul-Kategorie:** Integration/Extension Module  
**Komplexität:** ⭐⭐⭐ (Mittel - Inventory-Logik)

## Architektur & Design Patterns

### Kern-Klassen
- **SourceStockRepository**: Persistiert MSI Stock-Daten
- **InventoryImportProcessor**: Service Layer für MSI-Verarbeitung
- **SourceResolver**: Resolved Source IDs aus Source Codes
- **StockStatusCalculator**: Berechnet verfügbare Mengen
- **SaleableQuantityManager**: Verwaltet verkaufbare Mengen
- **SourceValidator**: Validiert Source Existence und Konfiguration

### Verwendete Patterns
- **Observer Pattern**: Zur Einklinken in Import-Lifecycle
- **Repository Pattern**: Für abstrakte Datenschicht
- **Service Layer Pattern**: Geschäftslogik isoliert
- **Strategy Pattern**: Verschiedene Quantity-Calculation Strategien
- **Calculator Pattern**: Für Saleable Qty Berechnung

## Abhängigkeiten

### TechDivision Dependencies
- **import-product** ^26.2 - Base Product Importer
- **Magento_Inventory** - MSI Framework

## Wichtige Entry Points

```php
// Source Stock Repository
SourceStockRepository::create($row): void
SourceStockRepository::findByProductAndSource($sku, $sourceCode): SourceStock
SourceStockRepository::findBySku($sku): array
```

## Database Schema

**inventory_source_item** - MSI Stock Items (pro Source)
- `source_code` - Source Identifier (z.B. 'warehouse_1')
- `sku` - Product SKU
- `quantity` - Verfügbare Menge in dieser Source
- `status` - In Stock (1) oder Out (0)

**inventory_stock** - Saleable Quantity (aggregiert)
- `stock_id` - Default Stock oder custom
- `website_id` - Website Context
- `product_id` / `sku` - Product Identifier

## Common Use Cases

### Use Case 1: Multi-Warehouse Inventory
```php
// CSV:
// sku,source_code,quantity,status
// PROD-001,warehouse_1,100,1
// PROD-001,warehouse_2,50,1
// PROD-001,warehouse_3,30,1
// Erstellt MSI: PROD-001 = 180 total (100+50+30 verfügbar)
```

### Use Case 2: Source-spezifische Availability
```php
// Jede Source hat eigene Quantity und Status
// Saleable Qty wird aggregiert über alle aktiven Sources
```

## Performance Considerations

1. **Source Lookups**: Source Codes werden zu IDs mapped
2. **Saleable Qty Calculation**: Aggregation über alle Sources
3. **Stock Status**: Berechnet aus verfügbaren Quantities
4. **Index Performance**: source_code und sku MÜSSEN indexiert sein

## Hints für KI-Agenten

### Kritisches Verständnis
1. **Multi-Source**: Inventory über mehrere Quellen verteilt
2. **Source-specific**: Jede Source hat separate Quantity
3. **Saleable Qty**: Berechnete Aggregation aus Sources
4. **Stock Status**: Auto-Berechnung aus Quantities
5. **MSI-Framework**: Erfordert Magento_Inventory aktiviert

### Häufige Fehler
- ❌ MSI nicht aktiviert (Modul ignoriert)
- ❌ Source Codes nicht validieren
- ❌ Quantities negativ (ungültig)
- ❌ Status-Werte falsch (nur 0/1)
- ❌ Saleable Qty manuell setzen (sollte berechnet)

## Known Limitations

- **MSI-Required**: Erfordert Magento_Inventory aktiviert
- **Source-Validierung**: Sources müssen in Inventory konfiguriert sein
- **Saleable Auto-Calc**: Wird automatisch berechnet (nicht importierbar)
- **Website-Context**: Separate Stocks pro Website

## Related Modules

- **import-product** - Base Product Importer
- **Magento_Inventory** - Core MSI Framework

## Zusammenfassung

`import-product-msi` ist ein **Tier 5 Modul** für Multi-Source Inventory Management. Verwaltet dezentrales Stock-Management über mehrere Quellen/Warehouses mit automatischer Saleable-Qty-Berechnung.

**Für Agenten:** MSI Importer mit Source-spezifischem Inventory und Auto-Calculation.