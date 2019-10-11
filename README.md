# Moment 5 - REST-webbtjänst

Denna REST-webbtjänst genererar data i JSON-format om kurser.

Webbtjänsten läser in vilken servermetod (GET, POST, PUT eller DELETE) som använts i anropet mot webbtjänsten, samt om något värde skickats med i URL:en - till exemepl ett ID.

I en switch-sats testas vilken av metoderna som använts och i det "case" som stämmer överens med den metod som skickats i anropet, anropas en klass-metod som ställer en fråga mot databasen - antingen om att hämta data eller att lägga till, förändra eller ta bort data. I de senare alternativen kontrolleras innan anropet till klass-metoden om värden skickats med i anropet eller i URL:en och lagras därefter i variabler som skickas med i anropet till klass-metoden och därefter i databas-frågan.

Webbtjänsten returnerar status-koder efter varje fråga mot databasen.

## URIs för att använda CRUD

GET     http://studenter.miun.se/~emno1501/dt173g/mom5/api/courses.php/courses"

POST    {"code": "DT173G", "name": "Webbutveckling III", "progression": "B", "plan": "https://www.miun.se/utbildning/kursplaner-och-utbildningsplaner/Sok-kursplan/kursplan/?kursplanid=21873"} http://studenter.miun.se/~emno1501/dt173g/mom5/api/courses.php/courses"

PUT    {"code": "DT173G", "name": "Webb III", "progression": "B", "plan": "https://www.miun.se/utbildning/kursplaner-och-utbildningsplaner/Sok-kursplan/kursplan/?kursplanid=21873"} http://studenter.miun.se/~emno1501/dt173g/mom5/api/courses.php/courses/24" *24 = ID på datan som ska ändras*

DELETE  http://studenter.miun.se/~emno1501/dt173g/mom5/api/courses.php/courses/24" *24 = ID på datan som ska tas bort*