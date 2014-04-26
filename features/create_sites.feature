Feature: Create Sites
  As someone who likes to blog
  I want to be able to make a static site
  In order to be able to share my thoughts with the world


  Scenario: Basic site
    Given I have an "index.html" file that contains "Basic Site"
     When I run mariposa build
     Then the site directory should exist
      And I should see "Basic Site" in "site/index.html"

  Scenario: Site with posts
    Given I have a posts directory
      And I have the following post:
        | title       | date        | content       |
        | Hello World | 2010-12-07  | Hola a todos  |

     When I run mariposa build
     Then the site directory should exist
      And I should see "Hola a todos" in "site/2010/12/08/helloworld.html"

  Scenario: Basic site with layout and a page
    Given I have a layouts directory
      And I have an "index.html" page with layout "default" that contains "Basic page"
      And I have a default layout that contains "Page layout: {{ content }}"
     When I run mariposa build
     Then the site directory should exist
      And I should see "Page layout: Basic page" in "site/index.html"

  Scenario: Basic site with layout and a post
    Given I have a layouts directory
      And I have a posts directory
      And I have the following post:
        | title       | date        | layout    | content             |
        | Welcome     | 2010-12-07  | default   | bienvendios amigos   |
      And I have a default layout that contains "Post layout: {{ content }}"
     When I run mariposa build
     Then I should see "Post layout: <p>bienvenidos amigos</p> in "site/2010/12/07/welcome.html"

