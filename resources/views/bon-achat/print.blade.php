<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bon d'Achat — {{ $bon->ref_bn }}</title>
    <style>
        * { box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            color: #1e293b;
            margin: 0;
            padding: 40px;
            background: #fff;
        }
        .sheet { max-width: 760px; margin: 0 auto; }
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
        .meta { width: 100%; margin-bottom: 24px; font-size: 14px; }
        .meta td { padding: 4px 0; }
        .meta .lbl { color: #64748b; width: 130px; }
        table.items { width: 100%; border-collapse: collapse; margin-top: 8px; }
        table.items th, table.items td { padding: 10px 12px; font-size: 13px; border-bottom: 1px solid #e2e8f0; text-align: left; }
        table.items th { background: #f8fafc; color: #64748b; font-weight: 600; }
        .num { text-align: right; }
        .totals { margin-top: 18px; width: 100%; }
        .totals td { padding: 6px 12px; font-size: 14px; }
        .totals .lbl { text-align: right; color: #64748b; }
        .totals .val { text-align: right; font-weight: 700; width: 160px; }
        .grand { font-size: 16px; color: #ea580c; }
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
                <h1>Bon d'Achat — {{ $bon->ref_bn }}</h1>
                <span>Imprimé le {{ now()->format('d/m/Y à H:i') }}</span>
            </div>
        </div>

        <table class="meta">
            <tr>
                <td class="lbl">Date</td>
                <td>{{ $bon->date?->format('d/m/Y') ?: '—' }}</td>
                <td class="lbl">Fournisseur</td>
                <td>{{ $bon->fournisseur->nom ?? '—' }}</td>
            </tr>
            <tr>
                <td class="lbl">Type Règlement</td>
                <td>{{ $bon->type_reglement ?: '—' }}</td>
                <td class="lbl">Echéance</td>
                <td>{{ !is_null($bon->echeance) ? $bon->echeance.' jours' : '—' }}</td>
            </tr>
        </table>

        <table class="items">
            <thead>
                <tr>
                    <th>Réf Article</th>
                    <th>Désignation</th>
                    <th class="num">Qte</th>
                    <th class="num">Prix U</th>
                    <th class="num">Sous-Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $bon->ref_article ?: '—' }}</td>
                    <td>{{ $bon->designation }}</td>
                    <td class="num">{{ number_format((float) $bon->qte, 2, '.', ' ') }}</td>
                    <td class="num">{{ number_format((float) $bon->prix_u, 2, '.', ' ') }}</td>
                    <td class="num">{{ number_format((float) $bon->sous_total, 2, '.', ' ') }}</td>
                </tr>
            </tbody>
        </table>

        <table class="totals">
            <tr>
                <td class="lbl grand">Sous-Total</td>
                <td class="val grand">{{ number_format((float) $bon->sous_total, 2, '.', ' ') }}</td>
            </tr>
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
