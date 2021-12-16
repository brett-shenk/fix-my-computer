# Fix My Computer
- [live](fixmycomputercentralpa.com)

<br>

## **GETTING STARTED**
Run `npm install`

#### REQUIREMENTS
- NODE `>=12.18.0`
- NPM `>=6.14.4`
- GULP `4.0`

#### LOCAL DEV
- Docker + Lando
- `lando start`

<br>

## **COMMANDS**
#### **GULP**
The core processes of the theme and what it can do.

- `gulp` watch for and compile theme assets
- `gulp dev` / `gulp prod` processes the theme assets once
- `gulp build` processes only the icons, sass and js once
- dev is default. prod compresses and removes comments
- `gulp images` compress images
- `gulp fonts` converts font from 1 format to other formats
- `gulp icons` Re-generate the icon font

#### **BROWSERSLIST**
The can-i-use for Gulp in processing SASS. Auto including helpful stuff for older browsers so you don't have to.

- `npx browserslist` | Lists all supported browsers
- `npx browserslist@latest --update-db` | Update to the latest browsers. Need to process sass afterwords.

<br>

#### **DEBUG**

| Commands                         | First <br> Time Only | Description |
| -------------------------------- | :-: | ---------------------------- |
| `gulp CleanHouse`                |     | Removes everything inside of the dist folder |
| `npx rimraf ./**/node_modules`   |     | *Efficiently* remove node_modules folder |

<br>

#### **LIGHTHOUSE**

| Commands                           | Description |
| ---------------------------------- | ---------------------------- |
| `lighthouse <url>`                 | Check a URL for mobile |
| `lighthouse <url> --preset=desktop`| Check URL for desktop |
| `lighthouse <url> --view`          | View report after it's ran |

<br>

## **DEPLOYMENT**
- ADA Compliance: Single A
- Server Cache: **W3 Total Cache**
- External Cache: <https://cloudflare.com>

<br>
