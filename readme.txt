=== WP-Appbox ===
Contributors: Marcelismus
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=SH9AAS276RAS6
Tags: google play, google, android, apps, apple, app store, ios, windows, windows phone, mobile, windows store, androidpit, blackberry, appworld, appbox, firefox, firefox marketplace, chrome, chrome web store, samsung, samsung apps
Requires at least: 3.4
Tested up to: 3.5
Stable tag: 1.5.3
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0

Via Shortcode schnell und einfach App-Details von Apps aus einer Reihe an App Stores in Artikeln oder Seiten anzeigen.


== Description ==

"WP-Appbox" ermöglicht es, via Shortcode schnell und einfach App-Details von Apps aus einer Reihe an App Stores in Artikeln oder auf Seiten anzuzeigen. Das Plugin bietet dabei (bisher) folgende App Stores an:

* App Store
* Mac App Store
* Google Play Store
* Windows Store
* Windows Phone Store
* Firefox Marketplace
* Firefox Erweiterungen
* Samsung Apps (Android)
* AndroidPit (Android)
* Chrome Web Store (Experimentell)

Info: Die BlackBerry World musste entfernt werden, weil BlackBerry derzeit keine Möglichkeit mehr bietet, auf die Daten zugreifen zu können.

= Einbindung =

Alle Stores in einem Shortcode integriert und können via Button im Editor von WordPress eingefügt werden. Der Aufbau des Shortcodes ist dabei immer der folgende:

[appbox *storename* *app-id* *format*]

Die Reihenfolge ist dabei egal - solange "appbox" vorne an steht. Die Storenamen sind dabei: appstore, googleplay, windowsstore, windowsphone, firefoxmarketplace, firefoxaddon, androidpit, samsungapps und chromewebstore. Wie ihr an die ID der entsprechenden Apps kommt, findet sich bebildert in den Einstellungen zu WP-Appbox. Das Format ist standardmäßig "simple", alternativ gibt es auch eine Anzeige mit "screenshots" und auch als "banner" (nur für Google Play und AndroidPit).

Daneben gibt es noch eine Reihe an Attributen, die verwendet werden können: noqrcode, preis=""/price="", alterpreis=""/oldprice="".

= Weitere Features =

* Zoom des QR-Codes bei MouseOver
* Anpassung an mobile Geräte mit kleineren Displays
* Anpassung an die Feedausgabe
* Caching der Daten zu Performancezwecken
* Komplett anpassbar via HTML und CSS
* Nutzung der TradeDoubler-ID für den (Mac) App Store
* Nutzung der Affili.net-ID für AndroidPit

= Systemanforderungen =
* PHP ab 5.2.4
* WordPress ab 3.4
* Server mit laufendem cURL und mb_eregi

= Support =
Supportanfragen und Probleme im Idealfall bitte direkt im [Blog](http://www.blogtogo.de/wp-appbox-app-badge-fuer-google-play-mac-app-store-windows-store-windows-phone-store-co/ "Blog") oder noch besser via [Twitter](https://twitter.com/Marcelismus "Twitter") melden. 

= Übersetzungen =
* Standard: Deutsch
* English (UK)
* English (US)
* French (by Laurent)

If you want to translate, contact me.

= Autor =
* [blogtogo.de](http://www.blogtogo.de "blogtogo.de")
* [hirngedoens.de](http://www.hirngedoens.de "hirngedoens.de")
* [der-s.com](http://www.der-s.com "der-s.com")
* [Twitter](https://twitter.com/Marcelismus "Twitter")
* [Google+](https://plus.google.com/106153855794163421374/ "Google+")

== Screenshots ==

1. Simpler App-Badge via App Store
2. Banner-Badge via AndroidPit
3. App-Badge mit Screenshots via Windows Store
4. Zoom des QR-Codes
5. Fallback-Anzeige für den Google-Badge
6. WP-Appbox Einstellungen "Allgemeines"
7. WP-Appbox Einstellungen "Editor & Banner"
8. WP-Appbox Einstellungen "Affiliate"
9. WP-Appbox Einstellungen "Hilfe"
10. Artikeleditor mit Buttons
11. Artikeleditor mit kombinierten Buttons


= Requirements =
* PHP ab 5.2.4
* WordPress ab 3.4
* Server mit laufendem cURL und mb_eregi

= Installation =
1. Downloadpaket entpacken
2. Den Plugin-Ordner nach "/wp-content/plugins/" hochladen
3. Das Plugin in WordPress aktivieren


Einfach in den Plugin-Ordner von WordPress extrahieren und aktivieren.


== Frequently Asked Questions ==
  
= Gibt es Vorraussetzungen für den Server? =
  Ja: Der Server muss mindestens auf PHP5 laufen und cURL, sowie mb_eregi unterstützen.

= Kann man die Ausgabe anpassen? =
  Ja - sämtliche Ausgabeelemente können mittels HTML und CSS nach belieben angepasst werden.

= Wieso werden die QR-Codes von 400x400 Pixel runterskaliert? =
  Der QR-Code-Generator von Google hat eine kleine Eigenheit, dass die QR-Codes nur im gesamten auf die fixe Größe erstellt werden - je kürzer die URL ist, desto kleiner wird der Code und desto höher ist der Wert "margin". Dies lässt sich derzeit auch mit einer "margin=0" Angabe nicht korrigieren. Ob es ein Feature oder ein Bug ist wird in den Google Groups diskutiert.
  
= Der Google-App-Badge liefert einen Bot-Fehler =
  Google erkennt aufgrund zu vieler Anfragen den Server als Bot und sperrt die Seite. Derzeit wird ein Fallback-Badge angezeigt, ich arbeite aber an einer Lösung, das Problem mittels Captcha-Eingabe zu umgehen.  


== Changelog ==

= 1.5.3 =
* Der Firefox Marketplace ist wieder implementiert
* CSS-Anpassungen

= 1.5.2 =
* Entfernung der Firefox Marketplace, da  Mozilla [keine Möglichkeit mehr bietet](http://www.blogtogo.de/mozilla-ueberarbeitet-den-firefox-marketplace-und-was-das-fuer-wp-appbox-bedeutet/ "Mozilla überarbeitet den Firefox Marketplace – und was das für WP-Appbox bedeutet"), auf die Daten zugreifen zu können
* Codeoptimierungen

= 1.5.1 =
* QR-Codes können auch temporär deaktiviert werden (Attribut: noqrcode)
* Der anzuzeigende Preis kann verändert werden (Attribut: preis="" oder price="")
* Es kann ein "alter Preis" angegeben werden (Attribut: alterpreis="" oder oldprice="")
* Codeoptimierungen

= 1.5.0 =
* Samsung Apps implementiert
* Bugfix bezüglich der Kürzung des Entwickler
* Codeoptimierungen (wie immer)

= 1.4.6 =
* Codeoptimierung und Bugfix im Google Play Store
* Der Cache kann temporär deaktiviert werden
* Kürzung des Titels kann optional deaktiviert werden
* Codeoptimierungen

= 1.4.5 =
* Kleinerer Bugfix in Sachen Play Store
* Optimierungen des CSS-Codes
* Die Summe der Versionsziffern ist 10, daher könnte es WP-Appbox X heißen - käme ich aus Cupertino ;)

= 1.4.4 =
* Codeoptimierungen

= 1.4.3 =
* Fix für den Windows Store (neue URL)
* Fix für den Windows Phone Store (neue URL)
* Zu lange App-Titel werden gekürzt
* French translation (by Laurent)
* Codeoptimierungen

= 1.4.2 =
* Kleinere CSS-Optimierungen

= 1.4.1 =
* Fix QR-Code

= 1.4.0 =
* Firefox Addons hinzugefügt
* QR-Codes können deaktiviert werden
* Fix zwecks Sprachdateien

= 1.3.3 =
* Fix für den QR-Code des (Mac) App Store
* Größere App Icons aus dem (Mac) App Store
* Sprachdatei (*.mo & *.po) hinzugefügt
* Entfernung der BlackBerry World, da  BlackBerry keine Möglichkeit mehr bietet, auf die Daten zugreifen zu können

= 1.3.2 =
* Fix für den (Mac) App Store

= 1.3.1 =
* Korrektur des AndroidPit-Links

= 1.3.0 =
* Überarbeitete Optionsseite
* Abfrage des (Mac) App Store via JSON API
* BlackBerry App World in BlackBerry World umbenannt
* Nutzung des AndroidPit-Affiliate-Programmes via Affili.net möglich
* Firefox Marketplace hinzugefügt
* Chrome Web Store hinzugefügt (experimentelles Feature)

= 1.2.2 =
* Fixed AndroidPit-Screenshots
* Bugfixes

= 1.2.1 =
* Fixed "Cache leeren"-Link

= 1.2.0 =
* Nutzung der Transient API von WordPress zum Cachen der Daten
* Cache kann komplett geleert werden
* Bugfix beim Windows Phone Store und Apps mit Umlauten
* Codeoptimierungen

= 1.1.3 =
* Codeoptimierungen

= 1.1.2 =
* Behebung eines Fehlers, dass die Caching-Zeit im Firefox nicht geändert werden konnte

= 1.1.1 =
* Fehlerausgabe eingefügt
* Codeoptimierungen

= 1.0.2 =
* Fehlerkorrektur siehe Version 1.0.1
* "Blank-Page"-Fehler bei der BlackBerry AppWorld behoben

= 1.0.1 =
* Fallback im Falle das die Anfrage an den Play Store als Bot erkannt wird

= 1.0.0 =
* Code-Freeze