<?php


class LayoutView {
  
  private static $login = 'LayoutView::Logout';
  
  public function render($isLoggedIn, LoginView $v, DateTimeView $dtv, $msg, RegisterView $rv, $name) {
	if(!empty($_SESSION['reg'])) {
		$exit = '<form method="post" > <input type="submit" name="' . self::$login . '" value="back to login"/> </form>';
		$view = $rv;
		$tit = '<h2>Register new user</h2>';
		}
	else {
		$exit = '';
		$view = $v;
		$tit = '';
		}
    $out = '<!DOCTYPE html>
      <html>
        <head>
          <meta charset="utf-8">
          <title>Login Example</title>
        </head>
        <body>
          <h1>Assignment 4</h1> '.$exit.'
          ' . $this->renderIsLoggedIn($isLoggedIn) . '
          '.$tit.'
          <div class="container">
              ' . $view->response($isLoggedIn, $msg, $name) . '
              
              ' . $dtv->show() . '
          </div>
         </body>
      </html>
    ';
	
	echo $out;
  }
  
  private function renderIsLoggedIn($isLoggedIn) {
    if ($isLoggedIn) {
      return '<h2>Logged in</h2>';
    }
    else {
      return '<h2>Not logged in</h2>';
    }
  }
  
  public function getRequestLogin() {
	if(isset($_REQUEST[LayoutView::$login]))
			return $_REQUEST[LayoutView::$login];
  }
  
}
