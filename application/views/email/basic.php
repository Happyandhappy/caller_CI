

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width">
    <title>CallerTech - Email</title>
    <!-- <style> - main -->
    <style type="text/css">
    body {
      font-family: sans-serif, Arial;
      background: #f5f8fa;
      padding: 30px;
      margin: 0;
    }
    .white-wrap {
      background: #fff;
      padding: 50px 25px;
      max-width: 700px;
      margin: auto;
      color: #868686;
    }
    .logo {
      margin-bottom: 40px;
      text-align: center;
    }
    .logo img {
      max-width: 360px;
    }

    h1 {
      font-size: 40px;
      color: #414042;
      font-weight: 400;
      margin: 0;
    }
    h3 {
      font-size: 26px;
      line-height: 28px;
      color: #414042;
      font-weight: 400;
      margin: 0;
      padding: 20px 0;
    }
    .pull-right {
      display: inline-block;
      float: right;
    }
    h5 {
      font-size: 18px;
      margin:  15px 0;
      font-weight: 400;
    }
    hr {
      display: block;
      height: 1px;
      border: 0;
      border-top: 1px solid #f5f3f6;
      margin: 15px 0;
      padding:  0; 
  }

  .btn-orange {
    display:  inline-block;
    background : #ed583b;
    color: #fff;
    font-size:  16px; /* should be 18 */
    line-height:  30px;
    padding:  12px 10px;
    min-width: 150px;
    text-decoration: none;
    border-radius: 4px;
  }

  .author {
    color: #414042;
    padding:  20px 0;
    font-weight:  bold;
  }

  p.big {
    font-size: 20px;
      line-height: 28px;
  }
  p.small{
      font-size: 18px;
      line-height: 27px;
  }
  h3 .small {
      font-size: 16px;
      line-height: 24px;
  }

  .btn-orange:hover {
    background : #de553a;

  }

  .footer {
    text-align: center;
    padding:  35px 10px;
  }

  .footer-hdr {
    color:  #1a1a1a;
    letter-spacing: .14em;
    font-size: 17px;
    text-transform: uppercase;
    font-weight:  bold;
  }

  .footer-par {
    color:  #868686;
    font-size:  15px;
  }

  .social-icons a {
    display: inline-block;
    margin:  10px 12px;
    opacity:  .8;
  }
  .social-icons a:hover {
    opacity:  1;
  }


  .table-wrap {
    background:  #414042;
      margin: 60px 0 40px 0;  
      max-width: 100%;
      overflow: auto;
      box-shadow: 0px 10px 25px 0px rgba(0, 0, 0, 0.2); 
  }

  .table-hdr {
    background:  #414042;
    color:  #fff;
      padding: 20px 30px;
      line-height:  20px;
  }

  table{
      table-layout: fixed;
      min-width: 100%;
      border-collapse: collapse;
      font-size: 14px;
      text-align:  left;
  }
   td {
      border:  1px solid #dfdfdf;
      padding: 20px 30px;
      line-height:  20px;
  }
  tr:nth-child(odd) {
    background:  #f5f8fa;
  }
  tr:nth-child(even) {
    background:  #fff;
  }
  tr td:first-child {
    background:  #edf3f7;
  }

    .btn-oring {
      background: #F37524 !important;
    }


    @media(max-width: 800px) {
      body {
        padding: 20px;
      }
      .white-wrap {
        max-width: 95%;
        padding: 30px 15px;
      }
      .logo {
        margin-bottom: 10px;
      }
      .logo img {
        max-width: 70%;
      }
      h1 {
        font-size: 28px;
        line-height: 34px;
      }
      h3 {
        font-size: 18px;
        line-height: 23px;
      }
    }
  </style>

  </head>
  <body>
  <div class="white-wrap">
    <div style="text-align:center">
      <div class="logo">
        <a href="<?php echo base_url()."/clientuser/dashboard";?>"><img src="<?php echo site_url('uploads/logo.png');?>" alt="" /></a>
      </div>
    </div>
    <div>
      <?php echo $main_content; ?>
    </div>
  </div>
  </body>
</html>