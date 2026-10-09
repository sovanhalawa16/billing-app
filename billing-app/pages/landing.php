<?php
// ============ DATA ============
$bisnisNama = setting('nama_bisnis', APP_NAME);
$logo = setting('logo');
$kontak = setting('kontak_admin', '');
$alamat = setting('alamat', '');

// WA untuk jualan (fallback ke kontak admin kalau kosong)
$waSales = preg_replace('/[^0-9]/', '', $kontak);
if (substr($waSales, 0, 1) === '0') $waSales = '62' . substr($waSales, 1);
if (!$waSales) $waSales = '628123456789';

// ============ ICON HELPER ============
function li_icon($name, $size = 22, $stroke = 2) {
    $icons = [
        'file'        => '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/>',
        'creditCard'  => '<rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/>',
        'checkCircle' => '<path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>',
        'barChart'    => '<line x1="12" y1="20" x2="12" y2="10"/><line x1="18" y1="20" x2="18" y2="4"/><line x1="6" y1="20" x2="6" y2="16"/>',
        'link'        => '<path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/>',
        'message'     => '<path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>',
        'shield'      => '<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>',
        'zap'         => '<polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/>',
        'smartphone'  => '<rect x="5" y="2" width="14" height="20" rx="2"/><line x1="12" y1="18" x2="12.01" y2="18"/>',
        'arrowR'      => '<line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/>',
        'arrowDown'   => '<line x1="12" y1="5" x2="12" y2="19"/><polyline points="19 12 12 19 5 12"/>',
        'logIn'       => '<path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/>',
        'check'       => '<polyline points="20 6 9 17 4 12"/>',
        'clock'       => '<circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>',
        'users'       => '<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>',
        'sparkle'     => '<path d="M12 3l1.9 5.6L19.5 10l-5.6 1.9L12 17.5l-1.9-5.6L4.5 10l5.6-1.4z"/>',
        'lock'        => '<rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>',
        'menu'        => '<line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/>',
        'x'           => '<line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>',
        'download'    => '<path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/>',
        'code'        => '<polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/>',
        'package'     => '<line x1="16.5" y1="9.4" x2="7.5" y2="4.21"/><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/>',
        'star'        => '<polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>',
        'helpCircle'  => '<circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/>',
        'chevDown'    => '<polyline points="6 9 12 15 18 9"/>',
        'layers'      => '<polygon points="12 2 2 7 12 12 22 7 12 2"/><polyline points="2 17 12 22 22 17"/><polyline points="2 12 12 17 22 12"/>',
        'settings'    => '<circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09a1.65 1.65 0 0 0-1-1.51 1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/>',
    ];
    $p = $icons[$name] ?? '';
    if (!$p) return '';
    return '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="'.$stroke.'" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">'.$p.'</svg>';
}

function li_wa($size = 20) {
    return '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413"/></svg>';
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="theme-color" content="#6366f1">
<title><?= e($bisnisNama) ?> — Aplikasi Tagihan & Pembayaran</title>
<meta name="description" content="Buat tagihan, kirim link ke pembayar, terima konfirmasi otomatis. Tersedia source code untuk kamu miliki sendiri.">
<style>
/* ============ RESET ============ */
*,*::before,*::after { box-sizing: border-box; margin: 0; padding: 0; -webkit-tap-highlight-color: transparent; }
html { scroll-behavior: smooth; -webkit-text-size-adjust: 100%; }
body {
    font-family: -apple-system, BlinkMacSystemFont, 'SF Pro Display', 'Segoe UI', Roboto, sans-serif;
    background: #ffffff;
    color: #0f172a;
    line-height: 1.55;
    -webkit-font-smoothing: antialiased;
    overflow-x: hidden;
}
img { max-width: 100%; display: block; }
a { text-decoration: none; color: inherit; }
button { font-family: inherit; cursor: pointer; border: none; background: none; }

/* ============ NAVBAR ============ */
.nav {
    position: sticky; top: 0; z-index: 100;
    background: rgba(255,255,255,0.85);
    backdrop-filter: saturate(180%) blur(20px);
    -webkit-backdrop-filter: saturate(180%) blur(20px);
    border-bottom: 1px solid rgba(15,23,42,0.06);
}
.nav-inner {
    max-width: 1120px; margin: 0 auto;
    padding: 14px 20px;
    display: flex; align-items: center; justify-content: space-between;
    gap: 16px;
}
.nav-brand {
    display: flex; align-items: center; gap: 10px;
    font-size: 17px; font-weight: 800; color: #0f172a;
    letter-spacing: -.3px;
}
.nav-logo {
    width: 34px; height: 34px; border-radius: 10px;
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    color: #fff;
    display: flex; align-items: center; justify-content: center;
    font-size: 15px; font-weight: 800;
    box-shadow: 0 4px 12px rgba(99,102,241,.35);
    overflow: hidden; flex-shrink: 0;
}
.nav-logo img { width: 100%; height: 100%; object-fit: contain; background: #fff; padding: 3px; }
.nav-brand-text span { color: #6366f1; }

.nav-links {
    display: flex; align-items: center; gap: 6px;
}
.nav-links a:not(.nav-btn) {
    padding: 8px 14px; border-radius: 8px;
    font-size: 13.5px; font-weight: 600; color: #64748b;
    transition: color .15s, background .15s;
}
.nav-links a:not(.nav-btn):hover { color: #0f172a; background: #f1f5f9; }

.nav-btn {
    display: inline-flex; align-items: center; gap: 7px;
    padding: 9px 16px; border-radius: 10px;
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    color: #fff;
    font-size: 13.5px; font-weight: 700;
    box-shadow: 0 4px 14px rgba(99,102,241,.3);
    transition: transform .2s, box-shadow .2s;
}
.nav-btn:hover { transform: translateY(-1px); box-shadow: 0 8px 20px rgba(99,102,241,.4); }

.nav-toggle {
    display: none;
    width: 40px; height: 40px; border-radius: 10px;
    align-items: center; justify-content: center;
    color: #0f172a;
    background: #f1f5f9;
}

/* ============ HERO ============ */
.hero {
    position: relative;
    padding: 70px 20px 80px;
    overflow: hidden;
}
.hero-bg { position: absolute; inset: 0; pointer-events: none; z-index: 0; }
.hero-bg .blob { position: absolute; border-radius: 50%; filter: blur(90px); opacity: .35; }
.hero-bg .blob.b1 { width: 480px; height: 480px; background: #c7d2fe; top: -180px; left: -160px; }
.hero-bg .blob.b2 { width: 420px; height: 420px; background: #ddd6fe; top: 50px; right: -180px; }
.hero-inner {
    max-width: 1120px; margin: 0 auto;
    position: relative; z-index: 1;
    display: grid; grid-template-columns: 1.15fr 1fr;
    gap: 60px; align-items: center;
}
.hero-badge {
    display: inline-flex; align-items: center; gap: 7px;
    padding: 7px 14px 7px 10px; border-radius: 100px;
    background: #eef2ff;
    color: #4f46e5;
    font-size: 12px; font-weight: 700;
    letter-spacing: .2px;
    margin-bottom: 22px;
}
.hero-badge .bdot {
    width: 18px; height: 18px; border-radius: 50%;
    background: linear-gradient(135deg,#6366f1,#8b5cf6);
    color: #fff;
    display: inline-flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.hero h1 {
    font-size: 52px; font-weight: 800;
    line-height: 1.08; letter-spacing: -1.5px;
    color: #0f172a;
    margin-bottom: 20px;
}
.hero h1 .hl {
    background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
    -webkit-background-clip: text;
    background-clip: text;
    -webkit-text-fill-color: transparent;
}
.hero-sub {
    font-size: 17px; color: #64748b;
    line-height: 1.6;
    max-width: 520px;
    margin-bottom: 32px;
}
.hero-cta { display: flex; gap: 12px; flex-wrap: wrap; margin-bottom: 30px; }
.btn-primary {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 14px 24px; border-radius: 12px;
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    color: #fff;
    font-size: 14.5px; font-weight: 700;
    box-shadow: 0 8px 22px rgba(99,102,241,.32);
    transition: transform .2s cubic-bezier(.22,1,.36,1), box-shadow .2s;
    cursor: pointer;
}
.btn-primary:hover { transform: translateY(-2px); box-shadow: 0 14px 32px rgba(99,102,241,.4); }
.btn-outline {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 14px 24px; border-radius: 12px;
    background: #fff;
    color: #334155;
    border: 1.5px solid #e2e8f0;
    font-size: 14.5px; font-weight: 700;
    transition: border-color .2s, color .2s, transform .2s;
    cursor: pointer;
}
.btn-outline:hover { border-color: #c7d2fe; color: #4f46e5; transform: translateY(-2px); }

.hero-mini {
    display: flex; gap: 22px; flex-wrap: wrap;
    font-size: 13px; color: #64748b;
    font-weight: 500;
}
.hero-mini .hm { display: inline-flex; align-items: center; gap: 6px; }
.hero-mini .hm svg { color: #16a34a; }

/* PHONE MOCKUP */
.hero-visual { position: relative; display: flex; justify-content: center; }
.phone-wrap { position: relative; width: 100%; max-width: 380px; animation: floatY 6s ease-in-out infinite; }
@keyframes floatY {
    0%,100% { transform: translateY(0); }
    50% { transform: translateY(-14px); }
}
.phone-wrap::before {
    content: '';
    position: absolute; inset: -30px;
    background: radial-gradient(circle at center, rgba(99,102,241,.15) 0%, transparent 70%);
    pointer-events: none; z-index: -1;
}
.phone {
    background: #fff; border-radius: 26px; padding: 18px;
    box-shadow: 0 24px 60px rgba(15,23,42,.18), 0 0 0 1px rgba(15,23,42,.04);
    position: relative;
}
.phone::before {
    content: ''; position: absolute; top: 12px; left: 50%; transform: translateX(-50%);
    width: 50px; height: 5px; border-radius: 3px; background: #e2e8f0;
}
.pm-head { display: flex; align-items: center; gap: 10px; padding: 14px 4px 12px; margin-bottom: 10px; }
.pm-logo {
    width: 36px; height: 36px; border-radius: 10px;
    background: linear-gradient(135deg,#6366f1,#8b5cf6);
    color: #fff; display: flex; align-items: center; justify-content: center;
    font-size: 15px; font-weight: 800; flex-shrink: 0;
}
.pm-head-info .pm-title { font-size: 13px; font-weight: 800; color: #0f172a; }
.pm-head-info .pm-sub { font-size: 10.5px; color: #94a3b8; margin-top: 1px; }
.pm-card { background: #f8fafc; border-radius: 14px; padding: 14px; margin-bottom: 10px; }
.pm-card-top {
    display: flex; justify-content: space-between; align-items: center;
    padding-bottom: 10px; border-bottom: 1px dashed #e2e8f0; margin-bottom: 10px;
}
.pm-inv {
    font-family: 'SF Mono', Monaco, monospace;
    font-size: 10.5px; font-weight: 700; color: #6366f1;
    background: #eef2ff; padding: 3px 8px; border-radius: 5px;
}
.pm-status {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 4px 9px; border-radius: 12px;
    background: #dcfce7; color: #166534;
    font-size: 9.5px; font-weight: 800;
    text-transform: uppercase; letter-spacing: .5px;
}
.pm-status .dot { width: 5px; height: 5px; border-radius: 50%; background: currentColor; }
.pm-row {
    display: flex; justify-content: space-between; align-items: center;
    font-size: 11px; padding: 4px 0; gap: 10px;
}
.pm-row .lbl { color: #94a3b8; font-weight: 500; }
.pm-row .val { color: #0f172a; font-weight: 700; text-align: right; }
.pm-total {
    display: flex; justify-content: space-between; align-items: center;
    padding-top: 12px; margin-top: 8px; border-top: 2px solid #0f172a;
}
.pm-total .lbl { font-size: 9.5px; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: .8px; }
.pm-total .val { font-size: 17px; font-weight: 800; color: #0f172a; letter-spacing: -.3px; font-variant-numeric: tabular-nums; }
.pm-methods { display: flex; gap: 6px; padding: 4px; }
.pm-method {
    flex: 1; height: 44px; border-radius: 10px;
    background: #f1f5f9; display: flex; align-items: center; justify-content: center;
    color: #94a3b8; font-size: 10px; font-weight: 700;
}
.pm-method.active {
    background: linear-gradient(135deg,#6366f1,#8b5cf6);
    color: #fff; box-shadow: 0 6px 14px rgba(99,102,241,.3);
}
.float-note {
    position: absolute; background: #fff; border-radius: 14px;
    padding: 12px 14px;
    box-shadow: 0 16px 40px rgba(15,23,42,.15);
    display: flex; align-items: center; gap: 10px;
    font-size: 12px; font-weight: 600;
    animation: floatY 5s ease-in-out infinite;
    z-index: 2;
}
.float-note.fn-1 { top: 10%; left: -20px; animation-delay: -1.5s; }
.float-note.fn-2 { bottom: 12%; right: -20px; animation-delay: -3s; }
.float-note .fn-ic {
    width: 32px; height: 32px; border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0; color: #fff;
}
.float-note .fn-ic.green { background: linear-gradient(135deg,#16a34a,#22c55e); }
.float-note .fn-ic.indigo { background: linear-gradient(135deg,#6366f1,#8b5cf6); }
.float-note .fn-body .fn-t1 { font-size: 11.5px; color: #0f172a; font-weight: 700; }
.float-note .fn-body .fn-t2 { font-size: 10px; color: #94a3b8; margin-top: 1px; font-weight: 500; }

/* ============ TRUST STRIP ============ */
.trust { padding: 30px 20px; background: #f8fafc; }
.trust-inner {
    max-width: 1120px; margin: 0 auto;
    display: flex; align-items: center; justify-content: center;
    gap: 40px; flex-wrap: wrap;
}
.trust-item {
    display: flex; align-items: center; gap: 10px;
    font-size: 13.5px; font-weight: 600; color: #475569;
}
.trust-item .ti-ic {
    width: 32px; height: 32px; border-radius: 9px;
    background: #fff; color: #6366f1;
    display: flex; align-items: center; justify-content: center;
    box-shadow: 0 2px 8px rgba(15,23,42,.06);
}

/* ============ SECTIONS ============ */
.section { padding: 90px 20px; }
.section-inner { max-width: 1120px; margin: 0 auto; }
.section-head { text-align: center; max-width: 640px; margin: 0 auto 56px; }
.section-badge {
    display: inline-block;
    padding: 6px 14px; border-radius: 100px;
    background: #eef2ff; color: #4f46e5;
    font-size: 11.5px; font-weight: 800;
    text-transform: uppercase; letter-spacing: 1px;
    margin-bottom: 14px;
}
.section-head h2 {
    font-size: 38px; font-weight: 800;
    line-height: 1.15; letter-spacing: -1px;
    color: #0f172a; margin-bottom: 14px;
}
.section-head p { font-size: 16px; color: #64748b; line-height: 1.6; }

/* ============ FEATURES ============ */
.features-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 20px;
}
.feature {
    background: #fff; padding: 28px 24px;
    border-radius: 20px;
    border: 1px solid #f1f5f9;
    box-shadow: 0 2px 12px rgba(15,23,42,.04);
    transition: transform .25s cubic-bezier(.22,1,.36,1), box-shadow .25s, border-color .25s;
}
.feature:hover {
    transform: translateY(-4px);
    box-shadow: 0 16px 40px rgba(99,102,241,.12);
    border-color: #e0e7ff;
}
.feature-icon {
    width: 52px; height: 52px; border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    margin-bottom: 18px; color: #fff;
}
.feature-icon.f-indigo { background: linear-gradient(135deg,#6366f1,#8b5cf6); }
.feature-icon.f-green  { background: linear-gradient(135deg,#16a34a,#22c55e); }
.feature-icon.f-amber  { background: linear-gradient(135deg,#d97706,#f59e0b); }
.feature-icon.f-blue   { background: linear-gradient(135deg,#2563eb,#3b82f6); }
.feature h3 { font-size: 17px; font-weight: 800; color: #0f172a; margin-bottom: 8px; letter-spacing: -.3px; }
.feature p { font-size: 14px; color: #64748b; line-height: 1.6; }

/* ============ HOW ============ */
.how { background: #f8fafc; }
.steps {
    display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px;
}
.step {
    background: #fff; padding: 32px 24px;
    border-radius: 20px;
    border: 1px solid #f1f5f9;
    box-shadow: 0 2px 12px rgba(15,23,42,.04);
    transition: transform .25s cubic-bezier(.22,1,.36,1), box-shadow .25s;
}
.step:hover { transform: translateY(-4px); box-shadow: 0 16px 40px rgba(99,102,241,.12); }
.step-num {
    width: 40px; height: 40px; border-radius: 12px;
    background: linear-gradient(135deg,#6366f1,#8b5cf6);
    color: #fff;
    display: flex; align-items: center; justify-content: center;
    font-size: 16px; font-weight: 800;
    margin-bottom: 18px;
    box-shadow: 0 6px 16px rgba(99,102,241,.3);
}
.step h3 { font-size: 17px; font-weight: 800; color: #0f172a; margin-bottom: 8px; letter-spacing: -.3px; }
.step p { font-size: 14px; color: #64748b; line-height: 1.65; }

/* ============ PRICING ============ */
.pricing-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 24px;
    align-items: stretch;
}
.price-card {
    background: #fff;
    border-radius: 24px;
    padding: 34px 28px;
    border: 1.5px solid #e2e8f0;
    box-shadow: 0 2px 12px rgba(15,23,42,.04);
    position: relative;
    transition: transform .3s cubic-bezier(.22,1,.36,1), box-shadow .3s, border-color .3s;
    display: flex;
    flex-direction: column;
}
.price-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 20px 50px rgba(99,102,241,.15);
    border-color: #c7d2fe;
}
.price-card.featured {
    border-color: #6366f1;
    background: linear-gradient(180deg, #fafbff 0%, #fff 30%);
    box-shadow: 0 12px 40px rgba(99,102,241,.2);
    transform: scale(1.03);
}
.price-card.featured:hover { transform: scale(1.03) translateY(-6px); }

.price-ribbon {
    position: absolute;
    top: -13px;
    left: 50%;
    transform: translateX(-50%);
    padding: 5px 16px;
    background: linear-gradient(135deg,#6366f1,#8b5cf6);
    color: #fff;
    font-size: 10.5px;
    font-weight: 800;
    letter-spacing: 1px;
    text-transform: uppercase;
    border-radius: 100px;
    box-shadow: 0 6px 16px rgba(99,102,241,.35);
    white-space: nowrap;
}
.price-name {
    font-size: 15px;
    font-weight: 800;
    color: #0f172a;
    letter-spacing: -.2px;
    margin-bottom: 6px;
}
.price-desc {
    font-size: 12.5px;
    color: #94a3b8;
    margin-bottom: 20px;
    line-height: 1.5;
    min-height: 36px;
}
.price-amount {
    display: flex;
    align-items: baseline;
    gap: 4px;
    margin-bottom: 8px;
}
.price-amount .rp {
    font-size: 16px;
    font-weight: 700;
    color: #64748b;
}
.price-amount .num {
    font-size: 38px;
    font-weight: 800;
    color: #0f172a;
    letter-spacing: -1.5px;
    line-height: 1;
}
.price-note {
    font-size: 11.5px;
    color: #94a3b8;
    margin-bottom: 24px;
    display: flex;
    align-items: center;
    gap: 6px;
}
.price-note .pdot {
    width: 5px; height: 5px; border-radius: 50%;
    background: #cbd5e1;
}

.price-features {
    list-style: none;
    display: flex;
    flex-direction: column;
    gap: 12px;
    margin-bottom: 24px;
    flex: 1;
}
.price-features li {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    font-size: 13px;
    color: #475569;
    line-height: 1.5;
}
.price-features li .pf-check {
    width: 18px; height: 18px;
    border-radius: 50%;
    background: #eef2ff;
    color: #6366f1;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
    margin-top: 1px;
}
.price-features li.off {
    opacity: .4;
}
.price-features li.off .pf-check {
    background: #f1f5f9;
    color: #cbd5e1;
}
.price-features li.off span {
    text-decoration: line-through;
}

.price-btn {
    display: flex; align-items: center; justify-content: center; gap: 8px;
    width: 100%;
    padding: 14px;
    border-radius: 12px;
    font-size: 14px; font-weight: 700;
    cursor: pointer;
    transition: all .2s;
    text-align: center;
}
.price-btn.primary {
    background: linear-gradient(135deg,#6366f1,#8b5cf6);
    color: #fff;
    box-shadow: 0 8px 20px rgba(99,102,241,.3);
}
.price-btn.primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 28px rgba(99,102,241,.4);
}
.price-btn.outline {
    background: #fff;
    color: #334155;
    border: 1.5px solid #e2e8f0;
}
.price-btn.outline:hover {
    border-color: #c7d2fe;
    color: #4f46e5;
    background: #fafbff;
}

/* ============ FAQ ============ */
.faq { background: #f8fafc; }
.faq-list {
    max-width: 760px;
    margin: 0 auto;
    display: flex;
    flex-direction: column;
    gap: 12px;
}
.faq-item {
    background: #fff;
    border-radius: 16px;
    border: 1px solid #f1f5f9;
    box-shadow: 0 2px 8px rgba(15,23,42,.03);
    overflow: hidden;
    transition: box-shadow .2s, border-color .2s;
}
.faq-item.open {
    border-color: #c7d2fe;
    box-shadow: 0 8px 24px rgba(99,102,241,.1);
}
.faq-q {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    padding: 20px 22px;
    cursor: pointer;
    font-size: 14.5px;
    font-weight: 700;
    color: #0f172a;
    user-select: none;
    transition: color .15s;
}
.faq-q:hover { color: #4f46e5; }
.faq-q .faq-chev {
    width: 28px; height: 28px;
    border-radius: 50%;
    background: #f1f5f9;
    color: #64748b;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
    transition: transform .3s cubic-bezier(.22,1,.36,1), background .2s, color .2s;
}
.faq-item.open .faq-chev {
    transform: rotate(180deg);
    background: #eef2ff;
    color: #6366f1;
}
.faq-a {
    max-height: 0;
    overflow: hidden;
    transition: max-height .35s cubic-bezier(.22,1,.36,1);
}
.faq-a-inner {
    padding: 0 22px 20px;
    font-size: 13.5px;
    color: #64748b;
    line-height: 1.7;
}

/* ============ CTA ============ */
.cta-section { padding: 80px 20px; }
.cta-box {
    max-width: 1120px; margin: 0 auto;
    background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #312e81 100%);
    border-radius: 28px;
    padding: 60px 40px;
    text-align: center;
    position: relative;
    overflow: hidden;
    box-shadow: 0 24px 60px rgba(15,23,42,.25);
}
.cta-box::before, .cta-box::after {
    content: ''; position: absolute; border-radius: 50%;
    filter: blur(80px); pointer-events: none;
}
.cta-box::before { width: 320px; height: 320px; background: rgba(99,102,241,.5); top: -100px; left: -80px; }
.cta-box::after { width: 280px; height: 280px; background: rgba(139,92,246,.5); bottom: -80px; right: -60px; }
.cta-content { position: relative; z-index: 1; }
.cta-box h2 {
    font-size: 36px; font-weight: 800;
    color: #fff;
    line-height: 1.15; letter-spacing: -1px;
    margin-bottom: 16px;
}
.cta-box p {
    font-size: 16px; color: #cbd5e1;
    max-width: 520px; margin: 0 auto 32px;
    line-height: 1.6;
}
.cta-actions { display: flex; gap: 12px; justify-content: center; flex-wrap: wrap; }
.cta-actions .btn-primary {
    background: #fff; color: #0f172a;
    box-shadow: 0 8px 24px rgba(0,0,0,.2);
}
.cta-actions .btn-primary:hover { box-shadow: 0 14px 32px rgba(0,0,0,.3); }
.cta-actions .btn-outline {
    background: rgba(255,255,255,.1);
    color: #fff;
    border-color: rgba(255,255,255,.2);
    backdrop-filter: blur(10px);
}
.cta-actions .btn-outline:hover {
    background: rgba(255,255,255,.15);
    border-color: rgba(255,255,255,.35);
    color: #fff;
}

/* ============ FOOTER ============ */
.footer { background: #0f172a; color: #94a3b8; padding: 60px 20px 30px; }
.footer-inner { max-width: 1120px; margin: 0 auto; }
.footer-top {
    display: grid;
    grid-template-columns: 1.5fr 1fr 1fr;
    gap: 40px;
    padding-bottom: 40px;
    border-bottom: 1px solid rgba(148,163,184,.12);
    margin-bottom: 30px;
}
.footer-brand { display: flex; align-items: center; gap: 12px; margin-bottom: 14px; }
.footer-brand .fb-logo {
    width: 36px; height: 36px; border-radius: 10px;
    background: linear-gradient(135deg,#6366f1,#8b5cf6);
    color: #fff;
    display: flex; align-items: center; justify-content: center;
    font-size: 15px; font-weight: 800;
    overflow: hidden; flex-shrink: 0;
}
.footer-brand .fb-logo img { width: 100%; height: 100%; object-fit: contain; background: #fff; padding: 3px; }
.footer-brand .fb-name { font-size: 15px; font-weight: 800; color: #fff; }
.footer-brand .fb-name span { color: #818cf8; }
.footer p.fb-desc { font-size: 13px; color: #94a3b8; line-height: 1.7; max-width: 360px; }
.footer h4 {
    font-size: 12px; color: #fff;
    text-transform: uppercase; letter-spacing: 1px;
    font-weight: 800; margin-bottom: 16px;
}
.footer ul { list-style: none; display: flex; flex-direction: column; gap: 10px; }
.footer ul a, .footer ul li {
    font-size: 13.5px; color: #94a3b8;
    transition: color .15s;
    display: flex; align-items: center; gap: 8px;
}
.footer ul a:hover { color: #fff; }
.footer ul svg { color: #6366f1; flex-shrink: 0; }
.footer-bottom {
    display: flex; justify-content: space-between; align-items: center;
    gap: 16px; flex-wrap: wrap;
    font-size: 12.5px; color: #64748b;
}
.footer-bottom .powered { display: inline-flex; align-items: center; gap: 6px; }
.footer-bottom .powered svg { color: #6366f1; }

/* ============ RESPONSIVE ============ */
@media (max-width: 900px) {
    .hero-inner { grid-template-columns: 1fr; gap: 50px; }
    .hero { padding: 50px 20px 60px; }
    .hero h1 { font-size: 40px; letter-spacing: -1px; }
    .hero-visual { order: 2; }
    .hero-text { order: 1; text-align: center; }
    .hero-badge { margin-left: auto; margin-right: auto; }
    .hero-sub { margin-left: auto; margin-right: auto; }
    .hero-cta { justify-content: center; }
    .hero-mini { justify-content: center; }
    .section-head h2 { font-size: 30px; }
    .cta-box h2 { font-size: 28px; }
    .cta-box { padding: 50px 30px; }
    .steps { grid-template-columns: 1fr; gap: 16px; }
    .footer-top { grid-template-columns: 1fr; gap: 30px; }
    .pricing-grid { grid-template-columns: 1fr; gap: 20px; max-width: 420px; margin: 0 auto; }
    .price-card.featured { transform: scale(1); }
    .price-card.featured:hover { transform: translateY(-6px); }
}
@media (max-width: 640px) {
    .nav-inner { padding: 12px 16px; }
    .nav-links a:not(.nav-btn) { display: none; }
    .nav-toggle { display: flex; }
    .hero h1 { font-size: 34px; letter-spacing: -.8px; }
    .hero-sub { font-size: 15px; }
    .hero { padding: 40px 16px 50px; }
    .section { padding: 60px 16px; }
    .section-head h2 { font-size: 26px; }
    .feature { padding: 24px 20px; }
    .step { padding: 26px 20px; }
    .cta-box { padding: 40px 24px; border-radius: 22px; }
    .cta-box h2 { font-size: 24px; }
    .cta-box p { font-size: 14.5px; }
    .btn-primary, .btn-outline { padding: 12px 20px; font-size: 14px; }
    .float-note.fn-1 { left: -10px; }
    .float-note.fn-2 { right: -10px; }
    .trust { padding: 24px 16px; }
    .trust-inner { gap: 20px; }
    .trust-item { font-size: 12.5px; }
    .price-card { padding: 28px 22px; }
    .price-amount .num { font-size: 32px; }
    .faq-q { padding: 18px; font-size: 13.5px; }
    .faq-a-inner { padding: 0 18px 18px; font-size: 13px; }
}
</style>
</head>
<body>

<!-- ============ NAVBAR ============ -->
<nav class="nav">
    <div class="nav-inner">
        <a href="./" class="nav-brand">
            <div class="nav-logo">
                <?php if ($logo && file_exists(UPLOAD_PATH . '/' . $logo)): ?>
                    <img src="<?= UPLOAD_URL . '/' . e($logo) ?>" alt="">
                <?php else: ?>
                    <?= strtoupper(substr($bisnisNama, 0, 1)) ?>
                <?php endif; ?>
            </div>
            <span class="nav-brand-text"><?= e(substr($bisnisNama, 0, 5)) ?><span><?= e(substr($bisnisNama, 5)) ?></span></span>
        </a>
        <div class="nav-links">
            <a href="#fitur">Fitur</a>
            <a href="#harga">Harga</a>
            <a href="#faq">FAQ</a>
            <a href="<?= url('login') ?>" class="nav-btn">
                <?= li_icon('logIn', 15, 2.5) ?>
                Login Admin
            </a>
        </div>
        <button type="button" class="nav-toggle" onclick="document.querySelector('.nav-links').classList.toggle('open')">
            <?= li_icon('menu', 20, 2.5) ?>
        </button>
    </div>
</nav>

<!-- ============ HERO ============ -->
<section class="hero">
    <div class="hero-bg">
        <div class="blob b1"></div>
        <div class="blob b2"></div>
    </div>
    <div class="hero-inner">
        <div class="hero-text">
            <div class="hero-badge">
                <div class="bdot"><?= li_icon('sparkle', 11, 2.5) ?></div>
                Source Code Tersedia — Siap Pakai
            </div>
            <h1>Aplikasi Tagihan & Pembayaran <span class="hl">Siap Pakai</span></h1>
            <p class="hero-sub">
                Buat tagihan, kirim link ke pembayar, terima konfirmasi otomatis.
                Punya sendiri source code-nya, install di hosting kamu, pakai selamanya.
            </p>
            <div class="hero-cta">
                <a href="#harga" class="btn-primary">
                    <?= li_icon('package', 17, 2.5) ?>
                    Lihat Paket Harga
                </a>
                <a href="#fitur" class="btn-outline">
                    Pelajari Fitur
                    <?= li_icon('arrowDown', 15, 2.5) ?>
                </a>
            </div>
            <div class="hero-mini">
                <div class="hm"><?= li_icon('check', 14, 2.5) ?> PHP Native + MySQL</div>
                <div class="hm"><?= li_icon('check', 14, 2.5) ?> Support WhatsApp</div>
                <div class="hm"><?= li_icon('check', 14, 2.5) ?> Full source code</div>
            </div>
        </div>

        <div class="hero-visual">
            <div class="phone-wrap">
                <div class="phone">
                    <div class="pm-head">
                        <div class="pm-logo">T</div>
                        <div class="pm-head-info">
                            <div class="pm-title"><?= e($bisnisNama) ?></div>
                            <div class="pm-sub">Halaman Pembayaran</div>
                        </div>
                    </div>
                    <div class="pm-card">
                        <div class="pm-card-top">
                            <span class="pm-inv">INV-2026-0018</span>
                            <span class="pm-status"><span class="dot"></span> Lunas</span>
                        </div>
                        <div class="pm-row">
                            <span class="lbl">Pembayar</span>
                            <span class="val">Budi Santoso</span>
                        </div>
                        <div class="pm-row">
                            <span class="lbl">Tagihan</span>
                            <span class="val">Iuran Kelas</span>
                        </div>
                        <div class="pm-total">
                            <span class="lbl">Total</span>
                            <span class="val">Rp 500.000</span>
                        </div>
                    </div>
                    <div class="pm-methods">
                        <div class="pm-method active">QRIS</div>
                        <div class="pm-method">BCA</div>
                        <div class="pm-method">DANA</div>
                    </div>
                </div>

                <div class="float-note fn-1">
                    <div class="fn-ic green"><?= li_icon('check', 16, 3) ?></div>
                    <div class="fn-body">
                        <div class="fn-t1">Pembayaran diterima</div>
                        <div class="fn-t2">Rp 500.000 · 2 menit lalu</div>
                    </div>
                </div>
                <div class="float-note fn-2">
                    <div class="fn-ic indigo"><?= li_icon('link', 16, 2.5) ?></div>
                    <div class="fn-body">
                        <div class="fn-t1">Link terkirim</div>
                        <div class="fn-t2">via WhatsApp</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============ TRUST STRIP ============ -->
<div class="trust">
    <div class="trust-inner">
        <div class="trust-item">
            <div class="ti-ic"><?= li_icon('code', 16, 2.2) ?></div>
            PHP Native + MySQL
        </div>
        <div class="trust-item">
            <div class="ti-ic"><?= li_icon('zap', 16, 2.2) ?></div>
            Ringan & Cepat
        </div>
        <div class="trust-item">
            <div class="ti-ic"><?= li_icon('smartphone', 16, 2.2) ?></div>
            Mobile Friendly
        </div>
        <div class="trust-item">
            <div class="ti-ic"><?= li_icon('message', 16, 2.2) ?></div>
            Support WhatsApp
        </div>
    </div>
</div>

<!-- ============ FITUR ============ -->
<section class="section" id="fitur">
    <div class="section-inner">
        <div class="section-head">
            <span class="section-badge">Fitur Lengkap</span>
            <h2>Semua yang Kamu Butuhkan<br>untuk Kelola Tagihan</h2>
            <p>Dirancang untuk memudahkan pekerjaan admin & memberi pengalaman terbaik untuk pembayar.</p>
        </div>

        <div class="features-grid">
            <div class="feature">
                <div class="feature-icon f-indigo"><?= li_icon('link', 24, 2.2) ?></div>
                <h3>Link Pembayaran Otomatis</h3>
                <p>Setiap tagihan punya link unik yang bisa langsung di-share ke WhatsApp, email, atau media lain.</p>
            </div>
            <div class="feature">
                <div class="feature-icon f-green"><?= li_icon('creditCard', 24, 2.2) ?></div>
                <h3>Multi Metode Pembayaran</h3>
                <p>QRIS, transfer bank, e-wallet — semua bisa disetup sesuai kebutuhan tanpa batasan.</p>
            </div>
            <div class="feature">
                <div class="feature-icon f-amber"><?= li_icon('checkCircle', 24, 2.2) ?></div>
                <h3>Konfirmasi Real-time</h3>
                <p>Pembayar upload bukti, admin approve/reject, status update otomatis di halaman pembayar.</p>
            </div>
            <div class="feature">
                <div class="feature-icon f-blue"><?= li_icon('barChart', 24, 2.2) ?></div>
                <h3>Laporan Lengkap</h3>
                <p>Riwayat transaksi dengan filter, pencarian, dan export ke Excel/CSV untuk pembukuan.</p>
            </div>
        </div>
    </div>
</section>

<!-- ============ CARA KERJA ============ -->
<section class="section how" id="cara">
    <div class="section-inner">
        <div class="section-head">
            <span class="section-badge">Cara Kerja</span>
            <h2>Hanya 3 Langkah Mudah</h2>
            <p>Dari buat tagihan sampai terima pembayaran, semua bisa dalam 1 menit.</p>
        </div>

        <div class="steps">
            <div class="step">
                <div class="step-num">1</div>
                <h3>Buat Tagihan</h3>
                <p>Isi data pembayar, item biaya, jatuh tempo. Sistem otomatis generate nomor invoice & link.</p>
            </div>
            <div class="step">
                <div class="step-num">2</div>
                <h3>Share Link</h3>
                <p>Kirim link via WhatsApp atau copy paste ke media lain. Pembayar tinggal buka & bayar.</p>
            </div>
            <div class="step">
                <div class="step-num">3</div>
                <h3>Terima Pembayaran</h3>
                <p>Pembayar upload bukti, admin verifikasi, status otomatis berubah jadi LUNAS. Done!</p>
            </div>
        </div>
    </div>
</section>

<!-- ============ PRICING ============ -->
<section class="section" id="harga">
    <div class="section-inner">
        <div class="section-head">
            <span class="section-badge">Pilih Paket</span>
            <h2>Harga Terjangkau,<br>Source Code Full</h2>
            <p>Sekali bayar, source code jadi milik kamu. Install di hosting sendiri, pakai selamanya.</p>
        </div>

        <div class="pricing-grid">

            <!-- BASIC -->
            <div class="price-card">
                <div class="price-name">Basic</div>
                <div class="price-desc">Cocok untuk personal, komunitas kecil, atau UMKM yang baru mulai.</div>
                <div class="price-amount">
                    <span class="rp">Rp</span>
                    <span class="num">350</span>
                    <span class="rp">rb</span>
                </div>
                <div class="price-note">
                    <span class="pdot"></span> Sekali bayar, no hidden fee
                </div>
                <ul class="price-features">
                    <li><span class="pf-check"><?= li_icon('check', 11, 3) ?></span> <span>Full source code PHP Native</span></li>
                    <li><span class="pf-check"><?= li_icon('check', 11, 3) ?></span> <span>Database SQL lengkap</span></li>
                    <li><span class="pf-check"><?= li_icon('check', 11, 3) ?></span> <span>Dokumentasi install PDF</span></li>
                    <li><span class="pf-check"><?= li_icon('check', 11, 3) ?></span> <span>Untuk 1 domain</span></li>
                    <li><span class="pf-check"><?= li_icon('check', 11, 3) ?></span> <span>Gratis update minor</span></li>
                    <li class="off"><span class="pf-check"><?= li_icon('x', 11, 3) ?></span> <span>Support WhatsApp</span></li>
                    <li class="off"><span class="pf-check"><?= li_icon('x', 11, 3) ?></span> <span>Bisa dijual ulang</span></li>
                </ul>
                <a href="https://wa.me/<?= $waSales ?>?text=<?= urlencode('Halo, saya minat paket BASIC (Rp 350rb) source code Tagihanku') ?>" target="_blank" rel="noopener" class="price-btn outline">
                    <?= li_wa(15) ?> Beli Basic
                </a>
            </div>

            <!-- PRO (Featured) -->
            <div class="price-card featured">
                <div class="price-ribbon">Paling Laris</div>
                <div class="price-name">Pro</div>
                <div class="price-desc">Pilihan terbaik untuk bisnis kecil & menengah dengan kebutuhan lebih lengkap.</div>
                <div class="price-amount">
                    <span class="rp">Rp</span>
                    <span class="num">550</span>
                    <span class="rp">rb</span>
                </div>
                <div class="price-note">
                    <span class="pdot"></span> Sekali bayar, no hidden fee
                </div>
                <ul class="price-features">
                    <li><span class="pf-check"><?= li_icon('check', 11, 3) ?></span> <span>Semua fitur di paket Basic</span></li>
                    <li><span class="pf-check"><?= li_icon('check', 11, 3) ?></span> <span>Unlimited domain & install</span></li>
                    <li><span class="pf-check"><?= li_icon('check', 11, 3) ?></span> <span>Support WhatsApp 30 hari</span></li>
                    <li><span class="pf-check"><?= li_icon('check', 11, 3) ?></span> <span>Bantuan install gratis</span></li>
                    <li><span class="pf-check"><?= li_icon('check', 11, 3) ?></span> <span>Setup WA Gateway siap pakai</span></li>
                    <li><span class="pf-check"><?= li_icon('check', 11, 3) ?></span> <span>Custom branding (logo & warna)</span></li>
                    <li class="off"><span class="pf-check"><?= li_icon('x', 11, 3) ?></span> <span>Bisa dijual ulang</span></li>
                </ul>
                <a href="https://wa.me/<?= $waSales ?>?text=<?= urlencode('Halo, saya minat paket PRO (Rp 550rb) source code Tagihanku') ?>" target="_blank" rel="noopener" class="price-btn primary">
                    <?= li_wa(15) ?> Beli Pro
                </a>
            </div>

            <!-- EXTENDED -->
            <div class="price-card">
                <div class="price-name">Extended</div>
                <div class="price-desc">Untuk developer & reseller yang mau jual ulang aplikasi ini.</div>
                <div class="price-amount">
                    <span class="rp">Rp</span>
                    <span class="num">1,2</span>
                    <span class="rp">jt</span>
                </div>
                <div class="price-note">
                    <span class="pdot"></span> Sekali bayar, no hidden fee
                </div>
                <ul class="price-features">
                    <li><span class="pf-check"><?= li_icon('check', 11, 3) ?></span> <span>Semua fitur di paket Pro</span></li>
                    <li><span class="pf-check"><?= li_icon('check', 11, 3) ?></span> <span>Lisensi reseller</span></li>
                    <li><span class="pf-check"><?= li_icon('check', 11, 3) ?></span> <span>Bisa jual ulang unlimited</span></li>
                    <li><span class="pf-check"><?= li_icon('check', 11, 3) ?></span> <span>Support WhatsApp 90 hari</span></li>
                    <li><span class="pf-check"><?= li_icon('check', 11, 3) ?></span> <span>Hak modifikasi penuh</span></li>
                    <li><span class="pf-check"><?= li_icon('check', 11, 3) ?></span> <span>Prioritas support & update</span></li>
                    <li><span class="pf-check"><?= li_icon('check', 11, 3) ?></span> <span>Update fitur 6 bulan</span></li>
                </ul>
                <a href="https://wa.me/<?= $waSales ?>?text=<?= urlencode('Halo, saya minat paket EXTENDED (Rp 1,2jt) source code Tagihanku') ?>" target="_blank" rel="noopener" class="price-btn outline">
                    <?= li_wa(15) ?> Beli Extended
                </a>
            </div>

        </div>
    </div>
</section>

<!-- ============ FAQ ============ -->
<section class="section faq" id="faq">
    <div class="section-inner">
        <div class="section-head">
            <span class="section-badge">FAQ</span>
            <h2>Pertanyaan yang Sering Ditanya</h2>
            <p>Belum ketemu jawabannya? Chat langsung ke WhatsApp kami.</p>
        </div>

        <div class="faq-list">
            <div class="faq-item">
                <div class="faq-q" onclick="toggleFaq(this)">
                    <span>Aplikasi ini dibuat pakai apa?</span>
                    <span class="faq-chev"><?= li_icon('chevDown', 14, 3) ?></span>
                </div>
                <div class="faq-a">
                    <div class="faq-a-inner">Dibuat dengan PHP Native (tanpa framework) + MySQL. Ringan, cepat, dan mudah dimodifikasi. Tidak butuh composer atau dependency apapun — cukup upload ke hosting biasa.</div>
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-trigger" style="display:none;"></div>
                <div class="faq-q" onclick="toggleFaq(this)">
                    <span>Install di hosting apa saja bisa?</span>
                    <span class="faq-chev"><?= li_icon('chevDown', 14, 3) ?></span>
                </div>
                <div class="faq-a">
                    <div class="faq-a-inner">Hampir semua hosting PHP + MySQL support. Termasuk hosting murah seperti InfinityFree, Niagahoster, Rumahweb, Hostinger, cPanel biasa, dan VPS.</div>
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-q" onclick="toggleFaq(this)">
                    <span>Ada demo buat dicoba dulu?</span>
                    <span class="faq-chev"><?= li_icon('chevDown', 14, 3) ?></span>
                </div>
                <div class="faq-a">
                    <div class="faq-a-inner">Ada. Chat WhatsApp kami untuk mendapatkan link demo & akses admin. Demo bisa dipakai buat coba semua fitur sebelum beli.</div>
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-q" onclick="toggleFaq(this)">
                    <span>Bedanya paket Basic, Pro, dan Extended?</span>
                    <span class="faq-chev"><?= li_icon('chevDown', 14, 3) ?></span>
                </div>
                <div class="faq-a">
                    <div class="faq-a-inner"><strong>Basic:</strong> 1 domain, tanpa support. <strong>Pro:</strong> unlimited domain + support 30 hari + bantuan install. <strong>Extended:</strong> semua fitur Pro + boleh dijual ulang unlimited + support 90 hari.</div>
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-q" onclick="toggleFaq(this)">
                    <span>Bayarnya gimana?</span>
                    <span class="faq-chev"><?= li_icon('chevDown', 14, 3) ?></span>
                </div>
                <div class="faq-a">
                    <div class="faq-a-inner">Transfer bank, QRIS, atau e-wallet (DANA/OVO/GoPay/ShopeePay). Detail pembayaran dikirim via WhatsApp setelah konfirmasi order.</div>
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-q" onclick="toggleFaq(this)">
                    <span>Berapa lama proses kirim source code?</span>
                    <span class="faq-chev"><?= li_icon('chevDown', 14, 3) ?></span>
                </div>
                <div class="faq-a">
                    <div class="faq-a-inner">Setelah pembayaran dikonfirmasi, source code dikirim dalam 1-2 jam (jam kerja). Format .zip berisi semua file + dokumentasi install.</div>
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-q" onclick="toggleFaq(this)">
                    <span>Bisa custom atau modifikasi?</span>
                    <span class="faq-chev"><?= li_icon('chevDown', 14, 3) ?></span>
                </div>
                <div class="faq-a">
                    <div class="faq-a-inner">Bisa. Source code full diberikan tanpa dienkripsi. Untuk basic & pro, modifikasi untuk internal kamu OK. Kalau mau jual ulang hasil modif, wajib pakai paket Extended.</div>
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-q" onclick="toggleFaq(this)">
                    <span>Ada garansi?</span>
                    <span class="faq-chev"><?= li_icon('chevDown', 14, 3) ?></span>
                </div>
                <div class="faq-a">
                    <div class="faq-a-inner">Garansi 7 hari untuk bug/error. Kalau ada masalah teknis dari aplikasi, kami perbaiki. Tidak ada refund kecuali aplikasi tidak bisa dipakai sama sekali karena kesalahan kami.</div>
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-q" onclick="toggleFaq(this)">
                    <span>Butuh WA Gateway buat notifikasi?</span>
                    <span class="faq-chev"><?= li_icon('chevDown', 14, 3) ?></span>
                </div>
                <div class="faq-a">
                    <div class="faq-a-inner">Tidak wajib. Aplikasi sudah support kirim manual via WA Web (buka tab wa.me). Kalau mau otomatis, bisa integrate WA Gateway seperti Fonnte/Wablas — panduan disertakan di paket Pro & Extended.</div>
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-q" onclick="toggleFaq(this)">
                    <span>Kalau ada yang bingung, bisa tanya?</span>
                    <span class="faq-chev"><?= li_icon('chevDown', 14, 3) ?></span>
                </div>
                <div class="faq-a">
                    <div class="faq-a-inner">Tentu. Semua paket punya WhatsApp support. Khusus Basic, support hanya untuk pertanyaan teknis dasar. Kalau butuh bantuan install, bisa upgrade ke Pro.</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============ CTA ============ -->
<section class="cta-section">
    <div class="cta-box">
        <div class="cta-content">
            <h2>Siap Punya Aplikasi Tagihan<br>Milik Kamu Sendiri?</h2>
            <p>Chat kami sekarang untuk konsultasi gratis atau langsung order. Respon cepat via WhatsApp.</p>
            <div class="cta-actions">
                <a href="https://wa.me/<?= $waSales ?>?text=<?= urlencode('Halo, saya mau order aplikasi Tagihanku. Bisa dibantu?') ?>" target="_blank" rel="noopener" class="btn-primary">
                    <?= li_wa(17) ?>
                    Chat & Order Sekarang
                </a>
                <a href="#harga" class="btn-outline">
                    Lihat Paket Lagi
                    <?= li_icon('arrowDown', 15, 2.5) ?>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- ============ FOOTER ============ -->
<footer class="footer">
    <div class="footer-inner">
        <div class="footer-top">
            <div>
                <div class="footer-brand">
                    <div class="fb-logo">
                        <?php if ($logo && file_exists(UPLOAD_PATH . '/' . $logo)): ?>
                            <img src="<?= UPLOAD_URL . '/' . e($logo) ?>" alt="">
                        <?php else: ?>
                            <?= strtoupper(substr($bisnisNama, 0, 1)) ?>
                        <?php endif; ?>
                    </div>
                    <div class="fb-name"><?= e(substr($bisnisNama, 0, 5)) ?><span><?= e(substr($bisnisNama, 5)) ?></span></div>
                </div>
                <p class="fb-desc">Aplikasi tagihan & pembayaran yang simple, cepat, dan bisa kamu miliki sendiri. Cocok untuk UMKM, komunitas, sekolah, dan freelancer.</p>
            </div>

            <div>
                <h4>Navigasi</h4>
                <ul>
                    <li><a href="./">Beranda</a></li>
                    <li><a href="#fitur">Fitur</a></li>
                    <li><a href="#harga">Harga</a></li>
                    <li><a href="#faq">FAQ</a></li>
                    <li><a href="<?= url('login') ?>">Login Admin</a></li>
                </ul>
            </div>

            <div>
                <h4>Kontak</h4>
                <ul>
                    <?php if ($kontak): ?>
                        <li><?= li_icon('message', 14, 2.2) ?> <?= e($kontak) ?></li>
                    <?php endif; ?>
                    <?php if ($alamat): ?>
                        <li><?= li_icon('smartphone', 14, 2.2) ?> <?= e(mb_substr($alamat, 0, 60)) ?><?= mb_strlen($alamat) > 60 ? '...' : '' ?></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>

        <div class="footer-bottom">
            <div>&copy; <?= date('Y') ?> <?= e($bisnisNama) ?>. All rights reserved.</div>
            <div class="powered">
                <?= li_icon('shield', 12, 2) ?>
                Powered by <?= e(APP_NAME) ?>
            </div>
        </div>
    </div>
</footer>

<script>
// Smooth scroll
document.querySelectorAll('a[href^="#"]').forEach(a => {
    a.addEventListener('click', function(e) {
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            e.preventDefault();
            target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    });
});

// FAQ toggle
function toggleFaq(el) {
    const item = el.parentElement;
    const answer = item.querySelector('.faq-a');
    const isOpen = item.classList.contains('open');

    // Close all
    document.querySelectorAll('.faq-item').forEach(f => {
        f.classList.remove('open');
        f.querySelector('.faq-a').style.maxHeight = null;
    });

    // Open clicked
    if (!isOpen) {
        item.classList.add('open');
        answer.style.maxHeight = answer.scrollHeight + 'px';
    }
}

// Reveal on scroll
const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.opacity = '1';
            entry.target.style.transform = 'translateY(0)';
            observer.unobserve(entry.target);
        }
    });
}, { threshold: 0.08, rootMargin: '0px 0px -40px 0px' });

document.querySelectorAll('.feature, .step, .section-head, .cta-box, .price-card, .faq-item').forEach(el => {
    el.style.opacity = '0';
    el.style.transform = 'translateY(20px)';
    el.style.transition = 'opacity .6s cubic-bezier(.22,1,.36,1), transform .6s cubic-bezier(.22,1,.36,1)';
    observer.observe(el);
});
</script>

</body>
</html>