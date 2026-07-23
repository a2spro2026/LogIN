<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Fiche Fournisseur — {{ $fournisseur->code }}</title>
    <style>
        * { box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            color: #1e293b;
            margin: 0;
            padding: 40px;
            background: #fff;
        }
        .sheet { max-width: 720px; margin: 0 auto; }
        .head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 3px solid #f97316;
            padding-bottom: 16px;
            margin-bottom: 28px;
        }
        .brand { font-size: 26px; font-weight: 800; color: #ea580c; letter-spacing: .5px; }
        .brand small { display: block; font-size: 12px; font-weight: 500; color: #64748b; letter-spacing: 2px; }
        .doc-title { text-align: right; }
        .doc-title h1 { font-size: 18px; margin: 0; color: #0f172a; }
        .doc-title span { font-size: 12px; color: #64748b; }
        table { width: 100%; border-collapse: collapse; margin-top: 8px; }
        th, td { text-align: left; padding: 12px 14px; font-size: 14px; border-bottom: 1px solid #e2e8f0; }
        th { width: 38%; color: #64748b; font-weight: 600; background: #f8fafc; }
        td { color: #0f172a; font-weight: 500; }
        .footer { margin-top: 36px; font-size: 12px; color: #94a3b8; text-align: center; }
        .actions { text-align: center; margin-top: 28px; }
        .btn {
            display: inline-block; cursor: pointer; border: 0;
            background: #f97316; color: #fff; font-size: 14px; font-weight: 600;
            padding: 10px 22px; border-radius: 8px; text-decoration: none;
        }
        @media print {
            body { padding: 0; }
            .actions { display: none; }
        }
    </style>
</head>
<body>
    <div class="sheet">
        <div class="head">
            <div class="brand">LogIN<small>LOCATION IMMOBILIÈRE</small></div>
            <div class="doc-title">
                <h1>Fiche Fournisseur</h1>
                <span>Imprimée le {{ now()->format('d/m/Y à H:i') }}</span>
            </div>
        </div>

        <table>
            <tbody>
                <tr><th>Date Création</th><td>{{ $fournisseur->date_creation?->format('d/m/Y') ?: '—' }}</td></tr>
                <tr><th>ID</th><td>{{ $fournisseur->code }}</td></tr>
                <tr><th>Nom Fournisseur</th><td>{{ $fournisseur->nom }}</td></tr>
                <tr><th>Ville</th><td>{{ $fournisseur->ville ?: '—' }}</td></tr>
                <tr><th>Contact</th><td>{{ $fournisseur->contact ?: '—' }}</td></tr>
                <tr><th>Type Règlement</th><td>{{ $fournisseur->type_reglement ?: '—' }}</td></tr>
                <tr><th>Echéance</th><td>{{ !is_null($fournisseur->echeance) ? $fournisseur->echeance.' jours' : '—' }}</td></tr>
                <tr><th>Solde Initial</th><td>{{ number_format((float) $fournisseur->solde_initial, 2, '.', ' ') }}</td></tr>
            </tbody>
        </table>

        <div class="footer">Document généré automatiquement — LogIN</div>

        <div class="actions">
            <a href="#" class="btn" onclick="window.print(); return false;">Imprimer</a>
        </div>
    </div>

    <script>
        window.addEventListener('load', function () { window.print(); });
    </script>
</body>
</html>
