# Dungeon Duel

## Over het project

Dungeon Duel is een turn-based multiplayer fantasy battle game gebouwd met Laravel.

Twee spelers nemen het tegen elkaar op in een arena en vallen elkaar om de beurt aan met:

* melee attacks
* spells
* defense abilities
* items en potions

Het spel is geïnspireerd door games zoals:

* Swords and Sandals 2
* Pokémon
* Raid: Shadow Legends

Maar dan als een eenvoudige web-based dungeon battle game.

---

# Features

## Multiplayer Turn-Based Combat

Spelers spelen om de beurt.

Tijdens een beurt kan een speler:

* Attack uitvoeren
* Heavy attack gebruiken
* Defend activeren
* Spell casten
* Potion gebruiken
* Turn beëindigen

---

# Character Classes

## Warrior

Sterke melee fighter met veel HP.

### Abilities

* Slash
* Rage Strike
* Shield Block

---

## Mage

Hoge magic damage maar weinig defense.

### Abilities

* Fireball
* Ice Blast
* Lightning Bolt

---

## Rogue

Snelle assassin met critical hit chance.

### Abilities

* Backstab
* Poison Knife
* Dodge

---

## Paladin

Balanced class met healing abilities.

### Abilities

* Holy Strike
* Heal
* Protection

---

# Combat System

## Stats

Iedere speler heeft:

| Stat        | Beschrijving          |
| ----------- | --------------------- |
| HP          | Health points         |
| Mana        | Magic points          |
| Strength    | Physical damage       |
| Defense     | Damage reduction      |
| Crit Chance | Kans op critical hits |
| Speed       | Bepaalt wie begint    |

---

# Status Effects

| Effect | Beschrijving        |
| ------ | ------------------- |
| Burn   | Damage over time    |
| Poison | Damage per beurt    |
| Shield | Verminderde damage  |
| Stun   | Skip volgende beurt |

---

# Battle Arena

De game speelt zich af in verschillende fantasy arena’s.

Voorbeelden:

* Dungeon
* Lava Cave
* Forest Temple
* Colosseum

Elke arena heeft:

* unieke achtergrond
* visuele effecten
* sfeeranimaties

---

# UI Features

## Battle Screen

De battle screen bevat:

* player sprites
* health bars
* mana bars
* action buttons
* battle log
* spell effects

---

# Battle Log

Voorbeeld:

```txt
Mage casts Fireball
Warrior takes 18 damage
Warrior is burning
```

---

# Tech Stack

## Backend

* Laravel
* PHP
* MySQL

---

## Frontend

* Blade
* TailwindCSS
* Alpine.js

---

# Database Structuur

## users

Laravel authentication users.

---

## games

Slaat actieve matches op.

| Kolom        | Beschrijving                 |
| ------------ | ---------------------------- |
| id           | Game ID                      |
| status       | waiting / active / finished  |
| current_turn | Welke speler aan de beurt is |
| winner_id    | Winnaar van de match         |

---

## game_players

Slaat player stats op.

| Kolom     | Beschrijving    |
| --------- | --------------- |
| user_id   | Speler          |
| game_id   | Match           |
| class     | Character class |
| hp        | Current health  |
| mana      | Current mana    |
| defending | Defending state |

---

## abilities

Bevat alle spells en abilities.

---

## game_logs

Slaat combat acties op.

---

# Project Structuur

```txt
app/
 ├── Models/
 ├── Http/
 ├── Services/
 │    └── BattleService.php
 └── ...
```

---

# BattleService

De game logic wordt beheerd in:

```txt
app/Services/BattleService.php
```

Voorbeelden van methods:

```php
attack()
heavyAttack()
castSpell()
applyEffect()
nextTurn()
checkWinner()
```

---

# MVP Goals

## Eerste versie

* Login/Register
* Matchmaking
* Turn system
* Basic attacks
* HP system
* Win/Lose systeem

---

# Toekomstige Features

## Mogelijke uitbreidingen

* Meer classes
* Meer spells
* Inventory systeem
* Ranked mode
* Match history
* Sound effects
* Animaties
* AI bots
* Loot systeem

---

# Installatie

## Clone project

```bash
git clone <repository>
```

---

## Dependencies installeren

```bash
composer install
npm install
```

---

## Environment file

```bash
cp .env.example .env
```

---

## Application key genereren

```bash
php artisan key:generate
```

---

## Database migraties

```bash
php artisan migrate
```

---

## Frontend starten

```bash
npm run dev
```

---

## Laravel server starten

```bash
php artisan serve
```

---

# Development Roadmap

## Phase 1

* Authentication
* Lobby system
* Create game
* Join game

---

## Phase 2

* Battle system
* Turns
* Damage system
* Health bars

---

## Phase 3

* Classes
* Spells
* Status effects
* Animaties

---

## Phase 4

* Polish
* Sound effects
* Better UI
* Balancing

---

# Leerdoelen

Met dit project worden de volgende technieken toegepast:

* OOP
* MVC structuur
* Database relaties
* Multiplayer logic
* State management
* Laravel services
* Frontend interaction
* Game systems
* CRUD functionaliteit

---

# Auteur

Dungeon Duel is ontwikkeld als schoolproject met Laravel en
