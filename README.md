# Z77 Persistence Module

Dieses Modul stellt die Persistenzschicht für das Z77 Framework bereit.
Es beinhaltet:

- ORM-Integration (Doctrine ORM 3)
- Repositories für Entities
- FileStorage für lokale Persistenz
- Entity-Resolver und Mapping-Hilfen

## Installation

Über Composer im Monorepo:

```bash
composer require z77/persistence

use Z77\Persistence\Repository\SomeEntityRepository;

$repo = new SomeEntityRepository();
$entity = $repo->find(1);

