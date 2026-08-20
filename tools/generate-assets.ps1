$ErrorActionPreference = "Stop"

Add-Type -AssemblyName System.Drawing
Add-Type -AssemblyName System.Windows.Forms

$root = Split-Path -Parent $PSScriptRoot
$assetDir = Join-Path $root "assets"
New-Item -ItemType Directory -Force -Path $assetDir | Out-Null

function New-Canvas {
  param(
    [int] $Width,
    [int] $Height,
    [string] $Start,
    [string] $End
  )

  $bitmap = New-Object System.Drawing.Bitmap($Width, $Height)
  $graphics = [System.Drawing.Graphics]::FromImage($bitmap)
  $graphics.SmoothingMode = [System.Drawing.Drawing2D.SmoothingMode]::AntiAlias
  $graphics.TextRenderingHint = [System.Drawing.Text.TextRenderingHint]::AntiAliasGridFit
  $rect = New-Object System.Drawing.Rectangle(0, 0, $Width, $Height)
  $brush = New-Object System.Drawing.Drawing2D.LinearGradientBrush(
    $rect,
    [System.Drawing.ColorTranslator]::FromHtml($Start),
    [System.Drawing.ColorTranslator]::FromHtml($End),
    35
  )
  $graphics.FillRectangle($brush, $rect)
  $brush.Dispose()

  return @{
    Bitmap = $bitmap
    Graphics = $graphics
  }
}

function Save-Canvas {
  param(
    [hashtable] $Canvas,
    [string] $Name
  )

  $path = Join-Path $assetDir $Name
  $Canvas.Bitmap.Save($path, [System.Drawing.Imaging.ImageFormat]::Png)
  $Canvas.Graphics.Dispose()
  $Canvas.Bitmap.Dispose()
}

function Solid-Brush([string] $Color) {
  return New-Object System.Drawing.SolidBrush([System.Drawing.ColorTranslator]::FromHtml($Color))
}

function Pen-Color([string] $Color, [int] $Width = 1) {
  return New-Object System.Drawing.Pen([System.Drawing.ColorTranslator]::FromHtml($Color), $Width)
}

function Draw-Text {
  param(
    [System.Drawing.Graphics] $Graphics,
    [string] $Text,
    [int] $X,
    [int] $Y,
    [int] $Size,
    [string] $Color,
    [string] $Style = "Regular"
  )

  $fontStyle = [System.Drawing.FontStyle]::$Style
  $font = New-Object System.Drawing.Font("Consolas", $Size, $fontStyle, [System.Drawing.GraphicsUnit]::Pixel)
  $brush = Solid-Brush $Color
  $Graphics.DrawString($Text, $font, $brush, $X, $Y)
  $font.Dispose()
  $brush.Dispose()
}

function Fill-Rect {
  param(
    [System.Drawing.Graphics] $Graphics,
    [int] $X,
    [int] $Y,
    [int] $W,
    [int] $H,
    [string] $Color
  )

  $brush = Solid-Brush $Color
  $Graphics.FillRectangle($brush, $X, $Y, $W, $H)
  $brush.Dispose()
}

function Draw-Terminal-Chrome {
  param(
    [System.Drawing.Graphics] $Graphics,
    [int] $Width
  )

  Fill-Rect $Graphics 0 0 $Width 70 "#151b25"
  $colors = @("#ff6b8a", "#ffd166", "#43ff9a")
  for ($i = 0; $i -lt 3; $i++) {
    $brush = Solid-Brush $colors[$i]
    $Graphics.FillEllipse($brush, 34 + ($i * 30), 25, 15, 15)
    $brush.Dispose()
  }
}

function Create-ProjectThumb {
  param(
    [string] $FileName,
    [string] $Title,
    [string] $Accent,
    [string] $Command
  )

  $canvas = New-Canvas 1200 720 "#080a10" "#111827"
  $g = $canvas.Graphics
  Draw-Terminal-Chrome $g 1200
  Fill-Rect $g 70 120 500 46 "#101722"
  Fill-Rect $g 70 198 320 26 $Accent
  Fill-Rect $g 70 246 450 22 "#273142"
  Fill-Rect $g 70 286 390 22 "#273142"
  Fill-Rect $g 70 326 470 22 "#273142"

  $panelBrush = Solid-Brush "#0c111a"
  $g.FillRectangle($panelBrush, 645, 116, 430, 456)
  $panelBrush.Dispose()

  $pen = Pen-Color "#273142" 2
  $g.DrawRectangle($pen, 645, 116, 430, 456)
  $pen.Dispose()

  for ($row = 0; $row -lt 6; $row++) {
    $y = 170 + ($row * 58)
    Fill-Rect $g 690 $y 160 16 "#243044"
    Fill-Rect $g 890 $y (80 + (($row % 3) * 38)) 16 $Accent
  }

  $gridPen = Pen-Color "#1f2a3a" 1
  for ($x = 0; $x -le 1200; $x += 80) {
    $g.DrawLine($gridPen, $x, 70, $x, 720)
  }
  for ($y = 70; $y -le 720; $y += 80) {
    $g.DrawLine($gridPen, 0, $y, 1200, $y)
  }
  $gridPen.Dispose()

  Draw-Text $g $Title 70 122 42 "#eef4fb" "Bold"
  Draw-Text $g "`$ $Command" 70 604 28 "#43ff9a" "Regular"
  Draw-Text $g "build: passing" 820 604 28 "#66d9ef" "Regular"

  Save-Canvas $canvas $FileName
}

function Create-Profile {
  $canvas = New-Canvas 900 900 "#080a10" "#162033"
  $g = $canvas.Graphics

  for ($x = 0; $x -lt 900; $x += 60) {
    $pen = Pen-Color "#1e293b" 1
    $g.DrawLine($pen, $x, 0, $x, 900)
    $g.DrawLine($pen, 0, $x, 900, $x)
    $pen.Dispose()
  }

  Fill-Rect $g 150 130 600 430 "#111827"
  Draw-Terminal-Chrome $g 900
  Draw-Text $g "class Developer {" 205 210 42 "#66d9ef" "Bold"
  Draw-Text $g "  focus = 'product';" 205 278 34 "#43ff9a" "Regular"
  Draw-Text $g "  stack = ['React','Node'];" 205 332 34 "#ffd166" "Regular"
  Draw-Text $g "}" 205 386 42 "#66d9ef" "Bold"

  $hood = Solid-Brush "#273142"
  $skin = Solid-Brush "#ffd7b5"
  $hair = Solid-Brush "#10131a"
  $accent = Solid-Brush "#43ff9a"
  $g.FillEllipse($hood, 268, 520, 364, 300)
  $g.FillEllipse($skin, 350, 448, 200, 210)
  $g.FillPie($hair, 330, 424, 240, 150, 180, 180)
  $g.FillRectangle($accent, 405, 700, 90, 42)
  $hood.Dispose()
  $skin.Dispose()
  $hair.Dispose()
  $accent.Dispose()

  $eye = Solid-Brush "#080a10"
  $g.FillEllipse($eye, 405, 535, 18, 18)
  $g.FillEllipse($eye, 492, 535, 18, 18)
  $eye.Dispose()

  $smile = Pen-Color "#080a10" 4
  $g.DrawArc($smile, 416, 565, 88, 48, 12, 156)
  $smile.Dispose()

  Save-Canvas $canvas "profile-avatar.png"
}

Create-Profile
Create-ProjectThumb "project-nova-dashboard.png" "Nova Analytics" "#43ff9a" "npm run insights"
Create-ProjectThumb "project-api-forge.png" "API Forge" "#66d9ef" "curl /schema"
Create-ProjectThumb "project-taskflow.png" "TaskFlow OS" "#ffd166" "task sync"
Create-ProjectThumb "project-devshop.png" "DevShop" "#ff6b8a" "stripe listen"
Create-ProjectThumb "project-pulse-ci.png" "Pulse CI" "#7dd3fc" "deploy watch"
Create-ProjectThumb "project-signal-notes.png" "Signal Notes" "#a7f3d0" "notes index"
