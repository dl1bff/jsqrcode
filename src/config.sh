#!/bin/sh

cat << !END | redis-cli

set DESC-KLIMA-SCHLAFZ "Klima im Schlafzimmer"
set VAL-KLIMA-SCHLAFZ "T-SCHLAFZ,H-SCHLAFZ"

set DESC-KLIMA-WOHNZ  "Klima im Wohnzimmer"
set VAL-KLIMA-WOHNZ   "T-WOHNZ,H-WOHNZ"

set DESC-T "Temperatur"
set FACTOR-T "1"
set FORMAT-T "%4.1f&deg;C"

set DESC-H "relative Luftfeuchtigkeit"
set FACTOR-H "1"
set FORMAT-H "%3.0f%%"

!END


