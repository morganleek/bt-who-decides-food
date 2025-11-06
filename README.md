# Bones Theme
An empty Wordpress theme using Vite for compilation and BrowserSync for live updates.

## Setup

```bash
npm install
```

#### In ```.env```
- Set ```PROXY_SOURCE``` in .evn *https://localhost:8888*

#### In ```frontend-config.json``` to reflect the directory of your 
- Update ```themeFolder``` value theme directory name *bt-folder-name*

### Development 
```bash
npm start
```

### Build
```bash
npm run build
```

### Git FTP
Set Git FTP settings. You may want to export any templates if these have been edited in WP.

```
[git-ftp]
        url = ftpes://1.1.1.1/public_html/wp-content/themes/{directory_name}
        user = "username"
        password = "password"
        insecure = 1
```
