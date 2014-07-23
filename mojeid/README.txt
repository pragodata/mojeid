mojeID autentifikační plugin pro Moodle
=======================================

Toto rozšíření přidá na standardní přihlašovací stranu Moodle blok pro možnost přihlášení přes autoritu mojeID.

Pokud se přes toho rozšíření uživatel poprvé přihlásí do Moodle, pak se jeho účet automaticky vytvoří.

Pokud ale už v systému je uživatel se stejným emailem, pak přihlášení skončí neúspěchem.
Tuto situaci je možné ošetřit požádáním správce systému o změnu autorizačního pluginu u daného účtu na metodu mojeID.

Instalace rozšíření:
--------------------
Od verze Moodle 2.5 je možné instalovat rozšíření automaticky z [Moodle.org](https://moodle.org/plugins/view.php?plugin=auth_googleoauth2).
Pro manuální instalaci, nebo pro jiné verze, následujte tyto kroky:

1. nahrajte obsah rozšíření do adresáře /auth/mojeid/

2. v nastavení Moodle rozšíření povolte (správa stránek > moduly > ověřování uživatelů)

3. následujte instrukce v nastavení rozšíření

Author
-------
[PragoData Consulting, s.r.o.](http://www.pragodata.cz)
phone: +420 545 211 580

[Moodle Partner - PragoData Consulting, s.r.o.](http://www.moodlepartner.cz)
