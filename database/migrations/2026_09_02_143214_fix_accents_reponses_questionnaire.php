<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
return new class extends Migration
{
    public function up(): void
    {
        DB::table('answers')->where('id', 5)->update(['answer' => 'Thiès']);
        DB::table('answers')->where('id', 10)->update(['answer' => 'Antinorex']);
        DB::table('answers')->where('id', 11)->update(['answer' => 'Pernabol']);
        DB::table('answers')->where('id', 12)->update(['answer' => 'Nurabol']);
        DB::table('answers')->where('id', 13)->update(['answer' => 'Ciptadine']);
        DB::table('answers')->where('id', 14)->update(['answer' => 'Appetine']);
        DB::table('answers')->where('id', 15)->update(['answer' => 'Pervital']);
        DB::table('answers')->where('id', 16)->update(['answer' => 'Nuravit']);
        DB::table('answers')->where('id', 17)->update(['answer' => 'Stimogene']);
        DB::table('answers')->where('id', 18)->update(['answer' => 'Trimetabol']);
        DB::table('answers')->where('id', 19)->update(['answer' => 'Tres-Orix']);
        DB::table('answers')->where('id', 20)->update(['answer' => 'Dynamogen']);
        DB::table('answers')->where('id', 21)->update(['answer' => 'Apetamin']);
        DB::table('answers')->where('id', 22)->update(['answer' => 'Desyrel']);
        DB::table('answers')->where('id', 23)->update(['answer' => 'Neuheptavit']);
        DB::table('answers')->where('id', 25)->update(['answer' => 'Très rarement']);
        DB::table('answers')->where('id', 28)->update(['answer' => 'Fréquemment']);
        DB::table('answers')->where('id', 29)->update(['answer' => 'Très fréquemment']);
        DB::table('answers')->where('id', 53)->update(['answer' => 'Réseaux sociaux/internet']);
        DB::table('answers')->where('id', 54)->update(['answer' => 'Professionnel de santé']);
        DB::table('answers')->where('id', 91)->update(['answer' => 'Modérément']);
        DB::table('answers')->where('id', 93)->update(['answer' => 'Énormément']);
    }
    public function down(): void
    {
        // Aucun retour nécessaire pour ces corrections de texte.
    }
};