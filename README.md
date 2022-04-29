# Meme Generator Bundle
## Extension for the [Contao CMS](https://www.contao.org)

This extension can be used to create memes with the [imgflip API](https://imgflip.com/api).   
Please note that this is just a test bundle to learn about contao extensions and symfony components.  
It is therefore **not intended to be used in a productive environment** as of now.

## Installation
Run ```composer require agonyz/contao-meme-generator-bundle``` in your CLI to install the extension.

## Configuration
To use the [imgflip API](https://imgflip.com/api) you need to register an account for [imgflip](https://imgflip.com/signup).   
You can edit the configuration in your ```config/config.yml```

```
# config/config.yml
# Agonyz Meme Generator
agonyz_contao_meme_generator:
  username: your-username
  password: your-password
  cache_top_memes: time you want the top memes to be cached in seconds (default 86400)
  load_bootstrap: true
  
# Contao configuration
contao:
  legacy_routing: false
  #....
```

## Memes
![Meme](docs/meme.png?raw=true "contao meme")
