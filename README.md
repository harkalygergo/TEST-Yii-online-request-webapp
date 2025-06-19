# TEST Yii OrderForm webapp
###### 2025.06.19.1

Készíts egy web alapú szoftvert, amely egy weboldalon keresztül fogadja egy építőipari vállalkozás ügyfeleitől érkező igényeket egy űrlapon.
A beérkező igényekhez a felhasználónak kelljen megadnia: Név, E-mail cím, Munka típusa (állapotfelmérés, alapozás-előkészítés, építkezés, műszaki ellenőrzés), Munka részletezése (szövegesen).

A felhasználó kapjon visszajelzést, hogy fogadta a rendszer az igényeit.

A szoftver tárolja az igényeket.

Készíts egy háttérfolyamatot, amely CSV formátumba exportálja a beérkezett igényeket.

A CSV-be kerüljön bele az összes mező, amelyet a felhasználó kitöltött, továbbá:

- igény beérkezésének időpontja
- egyéb információk a beküldőről (IP cím, stb.)

A háttérfolyamatnak lehessen megadni, hogy milyen időszakban beérkezett igényeket kérdezze le (hónapra vonatkozóan, tehát pl. lehessen csak a 2025-05 hónapban érkezett igényeket CSV-be exportálni).
