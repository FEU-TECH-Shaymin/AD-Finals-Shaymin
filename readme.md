<a name="readme-top">

<br/>

<br />
<div align="center">
  <a href="https://github.com/FEU-TECH-Shaymin/AD-Finals-Shaymin">
    <img src="./assets/img/outlastLogo.png" alt="Outlast" width="80%" height="auto">
  </a>
  <h3 align="center">Outlast</h3>
</div>
<div align="center">
  Outlast is a post-apocalyptic-themed e-commerce webpage where survivors can browse and purchase essential gear to stay alive. From survival tools and weapons to life-saving consumables, Outlast equips you with everything needed to thrive in a world where danger lurks around every corner. Prepare, protect, and prevail.
</div>

<br />

![](https://visit-counter.vercel.app/counter.png?page=FEU-TECH-Shaymin/AD-Finals-Shaymin)

| Student Number | WakaTime |
|-|-|
| Gagan | [![wakatime](https://wakatime.com/badge/user/443593d2-a49b-4deb-9e6c-bfa25506f1aa/project/d8ed5cda-cafb-47c5-908e-4ec4dffc1750.svg)](https://wakatime.com/badge/user/443593d2-a49b-4deb-9e6c-bfa25506f1aa/project/d8ed5cda-cafb-47c5-908e-4ec4dffc1750) |
| Gonzales | [![wakatime](https://wakatime.com/badge/user/92714f91-5bd0-4e5f-ad0e-ceb54c8406d2/project/41ef207f-725d-4863-8046-bfb3f133a597.svg)](https://wakatime.com/badge/user/92714f91-5bd0-4e5f-ad0e-ceb54c8406d2/project/41ef207f-725d-4863-8046-bfb3f133a597) |
| Manrique | [![wakatime](https://wakatime.com/badge/user/50d53971-71c4-47c9-a5ac-6d633c759326/project/773143f7-908b-4f91-a8a0-1566d88f8e25.svg)](https://wakatime.com/badge/user/50d53971-71c4-47c9-a5ac-6d633c759326/project/773143f7-908b-4f91-a8a0-1566d88f8e25) |
| Oxina | [![wakatime](https://wakatime.com/badge/user/65f5d1d3-0933-4b6c-b6df-d8bf043e70be/project/9072e330-ba90-4d0f-8f33-5f9a0cdb57b0.svg)](https://wakatime.com/badge/user/65f5d1d3-0933-4b6c-b6df-d8bf043e70be/project/9072e330-ba90-4d0f-8f33-5f9a0cdb57b0) |
| Rivera | [![wakatime](https://wakatime.com/badge/user/3347b15e-226a-471b-9f86-f04cdf705140/project/6e9fa798-b3cf-4fac-a6c4-0cfae883878d.svg)](https://wakatime.com/badge/user/3347b15e-226a-471b-9f86-f04cdf705140/project/6e9fa798-b3cf-4fac-a6c4-0cfae883878d) |

---

<br />
<br />

<!-- TODO: If you want to add more layers for your readme -->
<details>
  <summary>Table of Contents</summary>
  <ol>
    <li>
      <a href="#overview">Overview</a>
      <ol>
        <li>
          <a href="#key-components">Key Components</a>
        </li>
        <li>
          <a href="#technology">Technology</a>
        </li>
      </ol>
    </li>
    <li>
      <a href="#rule,-practices-and-principles">Rules, Practices and Principles</a>
    </li>
    <li>
      <a href="#resources">Resources</a>
    </li>
  </ol>
</details>

---

## Overview

<!-- TODO: To be changed -->
<!-- The following are just sample -->

Description of the project in details.

### Key Components

<!-- TODO: List of Key Components -->
<!-- The following are just sample -->

- Authentication & Authorization
- CRUD Operations for E-Commerce System
- Responsive Frontend UI
- Static & Dynamic Content Separation
- Database Integration
- Seeding, Migrate, and Reset Utilities
- Security Measures
- Error Handling & Custom 404 Pages

### Technology

#### Language
![HTML](https://img.shields.io/badge/HTML-E34F26?style=for-the-badge&logo=html5&logoColor=white)
![CSS](https://img.shields.io/badge/CSS-1572B6?style=for-the-badge&logo=css3&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)

#### Framework/Library
![Bootstrap](https://img.shields.io/badge/Bootstrap-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white)

#### Databases
![MySQL](https://img.shields.io/badge/MySQL-00758F?style=for-the-badge&logo=mysql&logoColor=white)
![MongoDB](https://img.shields.io/badge/MongoDB-47A248?style=for-the-badge&logo=mongodb&logoColor=white)
![PostgreSQL](https://img.shields.io/badge/PostgreSQL-336791?style=for-the-badge&logo=postgresql&logoColor=white)

## Rules, Practices and Principles

<!-- Do not Change this -->

1. Always use `AD-` in the front of the Title of the Project for the Subject followed by your custom naming.
2. Do not rename `.php` files if they are pages; always use `index.php` as the filename.
3. Add `.component` to the `.php` files if they are components code; example: `footer.component.php`.
4. Add `.util` to the `.php` files if they are utility codes; example: `account.util.php`.
5. Place Files in their respective folders.
6. Different file naming Cases
   | Naming Case | Type of code         | Example                           |
   | ----------- | -------------------- | --------------------------------- |
   | Pascal      | Utility              | Accoun.util.php                   |
   | Camel       | Components and Pages | index.php or footer.component.php |
8. Renaming of Pages folder names are a must, and relates to what it is doing or data it holding.
9. Use proper label in your github commits: `feat`, `fix`, `refactor` and `docs`
10. File Structure to follow below.

```
AD-ProjectName
└─ assets
|   └─ css
|   |   └─ name.css
|   └─ img
|   |   └─ name.jpeg/.jpg/.webp/.png
|   └─ js
|       └─ name.js
└─ components
|   └─ name.component.php
|   └─ templates
|      └─ name.component.php
└─ handlers
|   └─ name.handler.php
└─ layout
|   └─ name.layout.php
└─ pages
|  └─ pageName
|     └─ assets
|     |  └─ css
|     |  |  └─ name.css
|     |  └─ img
|     |  |  └─ name.jpeg/.jpg/.webp/.png
|     |  └─ js
|     |     └─ name.js
|     └─ index.php
└─ staticData
|  └─ name.staticdata.php
└─ utils
|   └─ name.utils.php
└─ vendor
└─ .gitignore
└─ bootstrap.php
└─ composer.json
└─ composer.lock
└─ index.php
└─ readme.md
└─ router.php
```
> The following should be renamed: name.css, name.js, name.jpeg/.jpg/.webp/.png, name.component.php(but not the part of the `component.php`), Name.utils.php(but not the part of the `utils.php`)

## Resources

| Title        | Purpose                                                                       | Link          |
| ------------ | ----------------------------------------------------------------------------- | ------------- |
| Login/Signup Page | Provides a reference implementation of responsive login and signup forms with modern styling and structure. | <a href="https://codepen.io/BROOK_BK7/pen/VwjwRWr">Codepen</a> |
| Glitch Effect | Used for the glitch animation effect for images or backgrounds in the landing page. | <a href="https://codepen.io/Diana-Moretti/pen/RNwyPOV">Codepen</a> |
| Glitch Text Effect | Used to create animated text glitch effects for the landing page. | <a href="https://codepen.io/hoskinshozzy/pen/jKRqXv">Codepen</a> |
| Sample Title | Sample purpose would be here like this and this is the example of what it is. | trykolang.com |