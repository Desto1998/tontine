<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Presentation impression</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
</head>
<style>
    * {
        font-family: "Roboto", sans-serif;
    }

    table {
        border-collapse: collapse;
        width: 100%;
    }

    table.heading-table, table.for-data{
        width: 100%;
        justify-content: space-between;
    }
    table.bordered-table, table.bordered-table th,table.bordered-table td,table.bordered-table tr{
        border: #0e63cc 1px solid;
        padding: 5px;
    }
    header table .for-logo {
        /*width: 200px;*/

    }
    header table .for-logo img {
        width: 100px;
        height: 80px;
    }
    tfoot{
        background-color: #eee;
    }
    header table .for-name {
        text-align: center;
        /*width: 300px;*/
        min-width: 340px;
    }

    header table .for-date {
        width: auto;
        text-align: right;
    }

    header table .for-name p {
        font-size: 12px;
    }

    header table .for-name h3 {
        font-family: "Arial Black";
        color: #0e63cc;
    }

    .bg-primary {
        background-color: #0e63cc;
        padding: 2em;
        text-align: center;
        color: #ffffff;
    }

    .number {
        text-align: right;
    }

    .total {
        font-weight: 700;
    }

    .for-garentie {
        width: 100%;
        margin-top: 20px;
    }
    .for-data{
        font-size: 12px;
    }
    .for-garentie tr td div {
        font-size: 12px;
        line-height: 1.6;
        padding: 8px;
        border: #a5a3a3 solid 1px;
        height: 20px;
        width: 155px;
    }

    .for-garentie tr td div .titre {
        font-weight: 700;
    }
    /*.space-for-footer {*/
    /*    height: 100px;*/
    /*}*/
    h3.section-heading{
        color: #f48815;
    }

    footer {
        position: fixed;
        bottom: -35px;
        left: 0px;
        right: 0px;
        height: 80px;
        text-align: center;
        line-height: 1;
        font-size: 12px;
        margin-top: 5px;
    }

    footer table {
        width: 100%;
    }

    footer table tr td {
        width: 33%;
    }

    footer table tr div {
        width: 158px;
        background-color: #0e63cc;
        padding: 10px;
        border-radius: 10px;
        color: #ffffff;
        font-size: 9px;
    }
    .text-right{
        text-align: right;
    }
    .page-break {
        page-break-after: always;
    }
    .pagenumber{
        position: fixed;
        left: 30px;
        right: 200px;
        bottom: -25px;
        text-align: center;
        margin-right: 50px;
    }
    .pagenumber .page-number:after { content: counter(page); position: fixed;font-size: 10px;z-index: 9000}
    .pagenumber .page-total:after { content: counter(page) "/" counter(pages); ;position: fixed}
</style>
<body style="margin-left: 7px; margin-right: 5px;">
<div class="pagenumber" style="width: 99%; justify-content: right">
    <span class="page-number" style="float: right"> </span>
    {{--    <span class="page-total float-right">/ </span>--}}
</div>
<header class="forhead">
    <table class="heading-table bordered-table">
        <tr>
            <td class="for-logo">
                {{--                @php--}}
                {{--                    $ImagePath = $_SERVER["DOCUMENT_ROOT"] . '/public/images/logo/logo_gssc.png';--}}
                {{--                @endphp--}}

{{--                                    <img src="{{url('/')}}{{ asset('images/logo/logo-sans-fond.png') }}" class="logo" alt="Logo not found">--}}
                <img src="{{url('/')}}{{ !empty($data['association']->logo) ? asset('images/profil/' . $data['association']->logo) : asset('images/logo/logo-sans-fond.png') }}" class="logo" alt="Logo not found">
            </td>
            <td class="for-name">
                <h3>{{ $data['association']->name }}</h3>
                <h6>Rapport de la réunion</h6>
            </td>
            <td class="for-date">
                <small><strong></strong><br></small>
                <small>Fait le</small><br>
                <small><strong>{{ $data['today'] }}</strong></small>
            </td>
        </tr>
    </table>
</header>
<div style="margin: 10px;" class="section-heading">

    <table>
        <thead>
        <tr>
            <th></th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>Ordre du jour: <strong>{{ $data['meeting']->agenda }}</strong></td>
            <td class="text-right">du: <strong>{{ $data['meeting_date'] }}</strong></td>
        </tr>
        </tbody>
    </table>
</div>
<div style="margin: 10px;" class="section-heading">
<h3 class="section-heading">Information de la séance de réunion</h3>
    <table style="font-size: 12px">
        <thead>
        <tr>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>Heure début <strong>{{ $data['meeting']->start_time }}</strong></td>
            <td class="text-right">Heure fin: <strong>{{ $data['meeting']->end_time }}</strong></td>
            <td class="text-right">Coodonateur: <strong>{{ $data['meeting']->coordinate->first_name }} {{ $data['meeting']->coordinate->last_name }}</strong></td>
            <td class="text-right">Heure fin: <strong>{{ $data['meeting']->end_time }}</strong></td>
        </tr>
        </tbody>
    </table>
    <p>
        Commentaire: <small>{{ $data['meeting']->comment }}</small>
    </p>
</div>

@php
    $total = 0;
@endphp
<h3 class="section-heading">Cotisations</h3>

@foreach($data['sessionContributions'] as $contribution)
    @php
        $totalC = 0;
    @endphp
    <div>
        <table class="for-data bordered-table" style="margin:  20px 0;text-align: center; font-size: 12px">
            <caption>{{ $contribution->contribution->name }}</caption>
            <thead>
            <tr>
                <th>#</th>
                <th>Membre</th>
                <th>Montat</th>
                <th>Statut</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data['meetingSessionMembers'] as $key=> $msm)
                @if ($msm->session_contribution_id==$contribution->id)
                    @php
                        $totalC += $msm->amount;
                    @endphp
                    <tr>
                        <td>{{ $key +1 }}</td>
                        <td>{{ $msm->first_name }} {{ $msm->last_name }}</td>
                        <td>{{ $msm->amount }}</td>
                        <td>{{ $msm->present }}</td>
                    </tr>
                @endif

            @endforeach

            </tbody>
            <tfoot>
            <tr>
                <th colspan="2" rowspan="1"></th>
                <td>Total </td>
                <td><strong>{{ $totalC }}</strong></td>
            </tr>
            </tfoot>
        </table>
    </div>

@endforeach
<h3 class="section-heading">Sanctions</h3>
<table class="for-data bordered-table">
    <caption>Liste des sanctions</caption>
    <thead>
    <tr>
        <th>#</th>
        <th>Sanction</th>
        <th>Membre</th>
        <th>Statut</th>
        <th>Montant</th>
        <th>Commentaire</th>
    </tr>
    </thead>
    <tbody>
    @php
        $totalC = 0;
    @endphp
    @foreach($data['meetingSanctions'] as $key=>$ms)
        @php
            $totalC += $ms->amount  ;
        @endphp
        <tr>
            <td>{{ $key+1 }}</td>
            <td>{{ $ms->title }}</td>
            <td>{{ $ms->first_name }} {{ $ms->last_name }}</td>
            <td>{{ $ms->pay_status }}</td>
            <td>{{ $ms->amount }}</td>
            <td>{{ $ms->comment }}</td>
        </tr>
    @endforeach
    </tbody>
    <tfoot>
    <tr>
        <th colspan="4" rowspan="1"></th>
        <td>Total </td>
        <td><strong>{{ $totalC }}</strong></td>
    </tr>
    </tfoot>
</table>
<h3 class="section-heading">Prèts</h3>
<table class="for-data bordered-table">
    <caption>Liste des prèts</caption>
    <thead>
    <tr>
        <th>#</th>
        <th>Raison</th>
        <th>Montant</th>
        <th>Membre</th>
        <th>Cotisation</th>
        <th>Date retour</th>
        <th>Type</th>
        <th>Interet</th>
    </tr>
    </thead>
    <tbody>
    @php
        $totalC =0  ;
    @endphp
    @foreach($data['meetingLoans'] as $key=>$ms)
        @php
            $totalC += $ms->amount ;
        @endphp
        <tr>
            <td>{{ $key+1 }}</td>
            <td>{{ $ms->reason }}</td>
            <td>{{ $ms->amount }}</td>
            <td>{{ $ms->first_name }} {{ $ms->last_name }}</td>
            <td>{{ $ms->name }}</td>
            <td>{{ $ms->return_date }}</td>
            <td>{{ $ms->type }}</td>
            <td>{{ $ms->interest }}</td>
        </tr>
    @endforeach
    </tbody>
    <tfoot>
    <tr>
        <th colspan="6" rowspan="1"></th>
        <td>Total </td>
        <td><strong>{{ $totalC }}</strong></td>
    </tr>
    </tfoot>

</table>
<h3 class="section-heading">Fonds</h3>
<table class="for-data bordered-table">
    <caption>Liste des fonds</caption>
    <thead>
    <tr>
        <th>#</th>
        <th>Montant</th>
        <th>Membre</th>
        <th>Description</th>
    </tr>
    </thead>
    <tbody>
    @php
        $totalC =0  ;
    @endphp
    @foreach($data['meetingFunds'] as $key=>$ms)
        <tr>
            <td>{{ $key+1 }}</td>
            <td>{{ $ms->amount }}</td>
            <td>{{ $ms->first_name }} {{ $ms->last_name }}</td>
            <td>{{ $ms->description }}</td>
        </tr>
    @endforeach
    </tbody>
    <tfoot>
    <tr>
        <th colspan="2" rowspan="1"></th>
        <td>Total </td>
        <td><strong>{{ $totalC }}</strong></td>
    </tr>
    </tfoot>
</table>
<h3 class="section-heading">Bénéficiaires/Gagnant</h3>
<div class="for-data">
    <table class="table for-data bordered-table">
        <caption>Liste des bénéficiaires</caption>
        <thead>
        <tr>
            <th>#</th>
            <th>Cotisation</th>
            <th>Membre</th>
            <th>Montant</th>
        </tr>
        </thead>
        <tbody>
        @php
            $totalC =0  ;
        @endphp
        @foreach($data['meetingWinners'] as $key=>$ms)
            @php
                $contribution_name= '';
                $totalC += $ms->take_amount  ;
            @endphp
            @foreach($data['sessionContributions'] as $sc)
                @if ($sc->id == $ms->session_contribution_id)
                    @php
                        $contribution_name = $sc->contribution->name;
                    @endphp
                @endif
            @endforeach
            <tr>
                <td>{{ $key+1 }}</td>
                <td>{{ $contribution_name }}</td>
                <td>{{ $ms->first_name }} {{ $ms->last_name }}</td>
                <td>{{ $ms->take_amount }}</td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <th colspan="2" rowspan="1"></th>
            <td>Total </td>
            <td><strong>{{ $totalC }}</strong></td>
        </tr>
        </tfoot>
    </table>
</div>
<br>
{{--<div class="space-for-footer"></div>--}}
<footer class="for-footer footer">

    <p style="text-align: center;">
        <small>{{ $data['association']->address }}</small><br>
        <small>Tel: {{ $data['association']->phone }}</small><br>
        <small>Email: {{ $data['association']->email }}</small><br>
        <small>Site: <a href="https://ch.destdevs.com/">ch.destdevs.com</a></small>
    </p>

</footer>
</body>

</html>
