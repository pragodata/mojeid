<?php

// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * @package auth_mojeid
 * @author Pragodata  {@link http://pragodata.cz}; Vlahovic
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
$string['auth_mojeiddescription']='<p>Umožňuje přihlášení pomocí autority mojeID.</p><p><strong>"Úroveň zabezpečení"</strong> je vhodná k vynucení použití důvěryhodnější verifikace. Ne každý uživatel je ale schopen využívat jiný než standardní postup pomocí hesla.</p><p>Nastavení <strong>"Starší 18 let"</strong> umožní přihlášení jen uživatelům mojeID, jejich účet je autorizován a jejichž věk přesáhl hranici 18 let.</p><p>Nastavení <strong>"Proč mojeID (URL)"</strong> využijete tehdy, když do svého Moodle začleníte stranu s vysvětlením důvodů, proč využívat autoritu mojeID. HTTP adresu směřujicí na tuto stranu, pak uložte do tohoto formulářového pole. Odkaz pod formulářem pro přihlášení pomocí mojeID, směřující na stranu s popisem mojeID bude potom směřovat na vámi zadanou adresu.</p><h3>Postup vytvoření strany "Proč mojeID"</h3><p>Přihlašte se a přejděte na titulní stranu Moodle. V menu "<strong>Správa stránky</strong>" povolte režim úprav. V "<strong>Hlavní nabíka</strong>" zvolte "<strong>Přidat činnost, nebo studijní materiál</strong>". Z nabídky vyberte možnost "<strong>Stránka</strong>" a zde do pole "<strong>Název</strong>" i "<strong>Popis</strong>" vložte text "<strong>Proč mojeID</strong>". Do "<strong>Obsahu stránky</strong>" vložte text, případně i obrázky z <a href="https://www.mojeid.cz/vyhody/">této webové stránky</a>. Uložte tlačítkem "<strong>Uložit a zobrazit</strong>" a z adresního řádku zobrazené strany okopírujte URL adresu, kterou vložíte do nastavení komponenty MojeID.</p><h3>Přidání loga "Podporuje mojeID"</h3><p>V menu zvolte "<strong>Správa stránek</strong>" -> "<strong>Jazyk</strong>" -> "<strong>Přizpůsobení jazyka</strong>". V zobrazeném selectboxu vyberte jazyk, který chcete upravit a potvrďte tlačítkem "<strong>Otevřít jazykový balíček pro úpravu</strong>". Po načtení balíčku potvrďte tlačítkem "<strong>Pokračovat</strong>". Ve filtru vyberte z nabídky "<strong>Core</strong>" -> "<strong>moodle.php</strong>" a jako identifikátor řetězce zadejte "<strong>loggedinnot</strong>" a stiskněte tlačítko "<strong>Zobraz řetězce</strong>". Potom do zobrazeného pole s řetězcem "<strong>Nejste přihlášeni</strong>" přidejte na konec tento text "<strong>&lt;br /&gt;&lt;img src="/auth/mojeid/api/image/logo-podporuje.png" width="125" height="102" /&gt;&lt;br /&gt;</strong>" a potvrďte tlačítkem "<strong>Ulož a zapiš řetězce do souboru</strong>".</p>';
$string['pluginname']='mojeID';
$string['sign_in_with']='Přihlásit přes mojeID';
$string['why']='Proč mojeID';
$string['create']='Založit účet mojeID';
$string['verification_cancelled']='Přihlašování zrušeno.';
$string['verification_failed']='OpenID autentifikace selhala:';
$string['not_exists_mojeid_user_data']='Ve svém profilu mojeID doplňte následující data, nebo je povolte během přihlašovacího procesu.';
$string['unknown_error_during_create_user']='Během vytváření uživatele nastala neznámá chyba.';
$string['unknown_error_during_login_user']='Během přihlašování uživatele nastala neznámá chyba.';
$string['security_level']='Úroveň zabezpečení';
$string['security_level_info']='Jakou úroveň zabezpečení budete vyžadovat u uživatelů přihlašovaných pomocí autority mojeID.';
$string['password']='Heslo';
$string['certificate']='Certifikát';
$string['disponsable_password']='Jednorázové heslo';
$string['email_already_used']='Email už je přiřazen jiné autorizační metodě.';
$string['unknown_error_during_communication_with_mojeid']='Během komunikace se serverem mojeID nastala neznámá chyba.';
$string['adult_control']='Starší 18 let';
$string['adult_control_info']='Zapněte, pokud chcete umožnit přístup pouze uživatelům starším 18 let.';
$string['adult_control_failed']='Kontrola plnoletosti byla neúspěšná.';
$string['why_mojeid_url']='Proč mojeID (URL)';
$string['why_mojeid_url_info']='Adresa v rámci této instalace Moodle na které je umístěno info o výhodách autentizační metody mojeID.';
$string['you_are_not_adult']='Nejste zletilý/zletilá.';
$string['your_account_is_not_valid']='Váš účet není validovaný.';
