# Table of contents
<details>
   <summary>Click here to expand content list.</summary>
   
1. [General information](#1-general-information)
2. [License](#2-license)
3. [System requirements](#3-system-requirements)
4. [Supported features](#4-supported-features)
    * [4.1 Changes to version 2.0](#41-changes-to-version-20)
5. [User interface](#5-user-interface)
6. [Setup guide](#6-setup-guide)
    * [6.1 Code snippets](#61-code-snippets)
7. [Contact details](#7-contact-details)
</details>

---

# 1 General information
”News 2.0" was created in Sublime by Annice Strömberg ([Annice.se](https://annice.se)), 2019. It is a simple WCM (Web Content Management) script that can be used to post news articles on a web page with full CRUD support for an admin user. Furthermore, the code is based on HTML5, CSS3, PHP and MySQL.

---

# 2 License
Released under the MIT license.

MIT: [http://rem.mit-license.org](http://rem.mit-license.org/), see [LICENSE](LICENSE).

---

# 3 System requirements
This script can be run on servers that support PHP and MySQL.

---

# 4 Supported features
* Login system based on sessions.
* Password encryption.
* Full CRUD functionality for the admin.
* Responsive design.
* Form validation.
* Pagination.

## 4.1 Changes to version 2.0:
* Refactored code to apply object oriented structure along with removed deprecated methods.
* Added support for responsive layout.

---

# 5 User interface
Screenshot of the start page to display the latest news visible for anonymous users:

<img src="https://diagrams.annice.se/php-news-2.0/gui-start.png" alt="" width="700">

Screenshot of the admin page to create news in desktop vs. responsive view:

<img src="https://diagrams.annice.se/php-news-2.0/gui-create-news.png" alt="" width="700">

Screenshot of the admin page to get an overview of the news articles to edit or delete in desktop vs. responsive view:

<img src="https://diagrams.annice.se/php-news-2.0/gui-edit-news.png" alt="" width="700">

Screenshot of the admin page in desktop vs. responsive view to edit admin details:

<img src="https://diagrams.annice.se/php-news-2.0/gui-edit-admin.png" alt="" width="700">

---

# 6 Setup guide
1. Copy the SQL code in the file "SQL.sql" and execute it to your MySQL supported database.

2. Open the file “database.php” in the folder “config” and re-save the file with to your database credentials.

3. Upload the folder “News2.0” to your PHP supported server and navigate to the page “create_user.php” to create your admin login credentials.

4. Login with your created admin credentials to be able to start managing news.

## 6.1 Code snippets
The following code can be put on any page to display the latest news - as long as the page is saved with the file extension “.php”. The default setting is to display the 10 latest entries, but you can modify this number in the "news_entries.php" file:

```php
<?php include "news_entries.php"; ?>
```

You can also create new admin-protected pages by placing the following code at the top of each page file you want protected:

```php
<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
}
?>
```
---

# 7 Contact details
For general feedback related to this script, such as any discovered bugs etc., you can contact me via the following email address: [info@annice.se](mailto:info@annice.se)
