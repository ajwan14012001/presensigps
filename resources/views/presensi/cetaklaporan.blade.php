<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>A4</title>

    <!-- Normalize or reset CSS with your favorite library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">

    <!-- Load paper.css for happy printing -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.4.1/paper.css">

    <!-- Set page size here: A5, A4 or A3 -->
    <!-- Set also "landscape" if you need -->
    <style>
        @page {
            size: A4
        }

        #title {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 16px;
            font-weight: bold;
        }

        .tabeldatakaryawan {
            margin-top: 40px;
        }

        .tabeldatakaryawan td {
            padding: 5px;
        }

        .tabelpresensi {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        .tabelpresensi tr th {
            border: 1px solid #000000;
            padding: 5px;
            background-color: #dbdbdb;
        }

        .tabelpresensi td {
            border: 1px solid #000000;
            padding: 5px;
        }
    </style>
</head>

<!-- Set "A5", "A4" or "A3" for class name -->
<!-- Set also "landscape" if you need -->

<body class="A4">
    @php
        function selisih($jam_masuk, $jam_keluar)
        {
            [$h, $m, $s] = explode(':', $jam_masuk);
            $dtAwal = mktime($h, $m, $s, '1', '1', '1');
            [$h, $m, $s] = explode(':', $jam_keluar);
            $dtAkhir = mktime($h, $m, $s, '1', '1', '1');
            $dtSelisih = $dtAkhir - $dtAwal;
            $totalmenit = $dtSelisih / 60;
            $jam = explode('.', $totalmenit / 60);
            $sisamenit = $totalmenit / 60 - $jam[0];
            $sisamenit2 = $sisamenit * 60;
            $jml_jam = $jam[0];
            return $jml_jam . ':' . round($sisamenit2);
        }
    @endphp
    <!-- Each sheet element should have the class "sheet" -->
    <!-- "padding-**mm" is optional: you can set 10, 15, 20 or 25 -->
    <section class="sheet padding-10mm">

        <table style="width: 100%;">
            <tr>
                <td style="width: 30px;">
                    <img src="{{ asset('assets/img/bbslogo.png') }}" width="70" height="70" alt="">
                </td>
                <td>
                    <span id="title">
                        LAPORAN PRESENSI SISWA <br>
                        PERIODE {{ strtoupper($namabulan[$bulan]) }} {{ $tahun }}<br>
                        SMA PLUS BABUSSALAM <br>
                    </span>
                    <span>
                        <i>Jl. Ciburial Indah No.2-6, Ciburial, Kec. Cimenyan, Kab. Bandung</i>
                    </span>
                </td>
            </tr>
        </table>
        <table class="tabeldatakaryawan">
            <tr>
                <td rowspan="6">
                    @php
                        $path = Storage::url('upload/karyawan/' . $karyawan->foto);
                    @endphp
                    <img src="{{ url($path) }}" width="130" height="150" alt="">
                </td>
            </tr>
            <tr>
                <td>NIS</td>
                <td>:</td>
                <td>{{ $karyawan->nik }}</td>
            </tr>
            <tr>
                <td>Nama Siswa</td>
                <td>:</td>
                <td>{{ $karyawan->nama_lengkap }}</td>
            </tr>
            <tr>
                <td>Kelas</td>
                <td>:</td>
                <td>{{ $karyawan->jabatan }}</td>
            </tr>
            <tr>
                <td>Jurusan</td>
                <td>:</td>
                <td>{{ $karyawan->nama_dept }}</td>
            </tr>
            <tr>
                <td>No. HP</td>
                <td>:</td>
                <td>{{ $karyawan->no_hp }}</td>
            </tr>
        </table>
        <table class="tabelpresensi">
            <tr>
                <th>No.</th>
                <th>Tanggal</th>
                <th>Jam Masuk</th>
                <th>Jam Pulang</th>
                <th>Keterangan</th>
                <th>Jml Jam</th>
            </tr>
            @foreach ($presensi as $p)
                @php
                    $jamterlambat = selisih('07:00:00', $p->jam_in);
                @endphp
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ date('d-m-y', strtotime($p->tgl_presensi)) }}</td>
                    <td>{{ $p->jam_in }}</td>
                    <td>{{ $p->jam_out != null ? $p->jam_out : 'Belum Absen' }}</td>
                    <td>
                        @if ($p->jam_in > '07:00')
                            Terlambat | {{ $jamterlambat }}
                        @else
                            Tepat Waktu
                        @endif
                    </td>
                    <td>
                        @if ($p->jam_out != null)
                            @php
                                $jmljamsekolah = selisih($p->jam_in, $p->jam_out);
                            @endphp
                        @else
                            @php
                                $jmljamsekolah = 0;
                            @endphp
                        @endif
                        {{ $jmljamsekolah }}
                    </td>
                </tr>
            @endforeach
        </table>

        <table width="100%" style="margin-top: 100px;">
            <tr>
                <td colspan="2" style="text-align: right; vertical-align: bottom;">Bandung, {{ date('d-m-Y') }}
                </td>
            </tr>
            <tr>
                <td style="text-align: center; vertical-align: bottom; height: 200px;">
                    <u>Nama Kesiswaan</u><br>
                    <i><b>Kesiswaan</b></i><br>
                </td>
                <td style="text-align: center; vertical-align: bottom;">
                    <u>Nama Wali Kelas</u><br>
                    <i><b>Wali Kelas</b></i><br>
                </td>
            </tr>
        </table>
    </section>

</body>

</html>
