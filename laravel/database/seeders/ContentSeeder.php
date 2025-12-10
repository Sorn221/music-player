<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Artist;
use App\Models\Album;
use App\Models\Track;
use App\Models\Country;
use App\Models\Tag;
use App\Models\Theme;

class ContentSeeder extends Seeder
{
    public function run(): void
    {
        // --------------------------------------------------------
        // 0. ПОЛУЧЕНИЕ/СОЗДАНИЕ СТРАН И ТЕГОВ
        // Используем firstOrCreate, чтобы гарантировать, что переменная содержит
        // ОБЪЕКТ МОДЕЛИ, а не только ID, для безопасного доступа через ->id.
        // --------------------------------------------------------

        $norwayObj = Country::firstOrCreate(['name' => 'Norway'], ['slug' => 'norway']);
        $swedenObj = Country::firstOrCreate(['name' => 'Sweden'], ['slug' => 'sweden']);
        $usObj = Country::firstOrCreate(['name' => 'United States'], ['slug' => 'united-states']);
        $germanyObj = Country::firstOrCreate(['name' => 'Germany'], ['slug' => 'germany']);
        $polandObj = Country::firstOrCreate(['name' => 'Poland'], ['slug' => 'poland']);
        $ukObj = Country::firstOrCreate(['name' => 'United Kingdom'], ['slug' => 'united-kingdom']);
        $franceObj = Country::firstOrCreate(['name' => 'France'], ['slug' => 'france']);
        $ukraineObj = Country::firstOrCreate(['name' => 'Ukraine'], ['slug' => 'ukraine']);

        // Для удобства в коде ниже будем использовать ID
        $norway = $norwayObj->id;
        $sweden = $swedenObj->id;
        $us = $usObj->id;
        $uk = $ukObj->id;
        $poland = $polandObj->id;
        $france = $franceObj->id;
        $ukraine = $ukraineObj->id;

        // --- Теги ---
        $tagRaw = Tag::where('slug', 'lo-fi-rawness')->first();
        $tagAtmospheric = Tag::where('slug', 'atmospheric')->first();
        $tagMelodic = Tag::where('slug', 'melodic')->first();
        $tagDepressive = Tag::where('slug', 'depressive')->first();
        $tagEpicSynth = Tag::where('slug', 'epic-synth')->first();
        $tagBlackgaze = Tag::where('slug', 'blackgaze')->first();
        $tagChaotic = Tag::where('slug', 'chaotic')->first();
        $tagSymphonic = Tag::firstOrCreate(['name' => 'Symphonic'], ['slug' => 'symphonic']);
        $tagNuMetal = Tag::firstOrCreate(['name' => 'Nu Metal'], ['slug' => 'nu-metal']);
        $tagViking = Tag::firstOrCreate(['name' => 'Viking'], ['slug' => 'viking']);

        // --- Темы ---
        $themeSatanism = Theme::where('slug', 'satanism-anti-christianity')->first();
        $themeForest = Theme::where('slug', 'forest-mysticism')->first();
        $themeDepression = Theme::where('slug', 'depression-isolation')->first();
        $themePaganism = Theme::where('slug', 'paganism-norse-mythology')->first();
        $themeOccult = Theme::firstOrCreate(['name' => 'Occultism'], ['slug' => 'occultism']);


        // --------------------------------------------------------
        // 1. АРТИСТЫ (База + Дополнения)
        // --------------------------------------------------------

        // --- BLACk METAL BASE ---
        $bathory = Artist::create(['name' => 'Bathory', 'slug' => 'bathory', 'country_id' => $sweden, 'formed_year' => 1983]);
        $mayhem = Artist::create(['name' => 'Mayhem', 'slug' => 'mayhem', 'country_id' => $norway, 'formed_year' => 1984]);
        $burzum = Artist::create(['name' => 'Burzum', 'slug' => 'burzum', 'country_id' => $norway, 'formed_year' => 1991]);
        $darkthrone = Artist::create(['name' => 'Darkthrone', 'slug' => 'darkthrone', 'country_id' => $norway, 'formed_year' => 1986]);
        $immortal = Artist::create(['name' => 'Immortal', 'slug' => 'immortal', 'country_id' => $norway, 'formed_year' => 1991]);
        $emperor = Artist::create(['name' => 'Emperor', 'slug' => 'emperor', 'country_id' => $norway, 'formed_year' => 1991]);
        $dissection = Artist::create(['name' => 'Dissection', 'slug' => 'dissection', 'country_id' => $sweden, 'formed_year' => 1989]);
        $marduk = Artist::create(['name' => 'Marduk', 'slug' => 'marduk', 'country_id' => $sweden, 'formed_year' => 1990]);
        $behemoth = Artist::create(['name' => 'Behemoth', 'slug' => 'behemoth', 'country_id' => $poland, 'formed_year' => 1991]);
        $cradleoffilth = Artist::create(['name' => 'Cradle of Filth', 'slug' => 'cradle-of-filth', 'country_id' => $uk, 'formed_year' => 1991]);
        $wolves = Artist::create(['name' => 'Wolves in the Throne Room', 'slug' => 'wittr', 'country_id' => $us, 'formed_year' => 2003]);
        $alcest = Artist::create(['name' => 'Alcest', 'slug' => 'alcest', 'country_id' => $france, 'formed_year' => 1999]);

        // --- NEW BLACK METAL ARTISTS ---
        $gorgoroth = Artist::create(['name' => 'Gorgoroth', 'slug' => 'gorgoroth', 'country_id' => $norway, 'formed_year' => 1992]);
        $enslaved = Artist::create(['name' => 'Enslaved', 'slug' => 'enslaved', 'country_id' => $norway, 'formed_year' => 1991]);
        $watain = Artist::create(['name' => 'Watain', 'slug' => 'watain', 'country_id' => $sweden, 'formed_year' => 1998]);
        $satyricon = Artist::create(['name' => 'Satyricon', 'slug' => 'satyricon', 'country_id' => $norway, 'formed_year' => 1991]);
        // ИСПОЛЬЗУЕМ $ukraine ВМЕСТО $ukraine->id, так как мы преобразовали переменные выше
        $drudkh = Artist::create(['name' => 'Drudkh', 'slug' => 'drudkh', 'country_id' => $ukraine, 'formed_year' => 2002]);
        $agalloch = Artist::create(['name' => 'Agalloch', 'slug' => 'agalloch', 'country_id' => $us, 'formed_year' => 1995]);

        // --- NU METAL ARTISTS ---
        $deftones = Artist::create(['name' => 'Deftones', 'slug' => 'deftones', 'country_id' => $us, 'formed_year' => 1988]);
        $korn = Artist::create(['name' => 'Korn', 'slug' => 'korn', 'country_id' => $us, 'formed_year' => 1993]);
        $slipknot = Artist::create(['name' => 'Slipknot', 'slug' => 'slipknot', 'country_id' => $us, 'formed_year' => 1995]);
        $soad = Artist::create(['name' => 'System of a Down', 'slug' => 'soad', 'country_id' => $us, 'formed_year' => 1994]);


        // --------------------------------------------------------
        // 2. ДРЕВО ЭВОЛЮЦИИ (Influences)
        // --------------------------------------------------------

        $mayhem->influencers()->attach($bathory->id);
        $darkthrone->influencers()->attach($bathory->id);
        $immortal->influencers()->attach($bathory->id);
        $enslaved->influencers()->attach($bathory->id);

        $dissection->influencers()->attach($mayhem->id);
        $marduk->influencers()->attach($darkthrone->id);
        $gorgoroth->influencers()->attach($mayhem->id);
        $satyricon->influencers()->attach($emperor->id);

        $wolves->influencers()->attach($immortal->id);
        $alcest->influencers()->attach($emperor->id);
        $drudkh->influencers()->attach($burzum->id);
        $agalloch->influencers()->attach($enslaved->id);


        // --------------------------------------------------------
        // 3. АЛЬБОМЫ И ТРЕКИ (ВСЕ АЛЬБОМЫ С ТРЕКАМИ!)
        // --------------------------------------------------------

        // === BLACk METAL CORE ALBUMS ===

        // 3.1. Mayhem - De Mysteriis Dom Sathanas (1994)
        $albumMayhem = Album::create([
            'artist_id' => $mayhem->id, 'title' => 'De Mysteriis Dom Sathanas', 'slug' => 'de-mysteriis-dom-sathanas',
            'release_year' => 1994, 'cover_image_path' => '/img/covers/mayhem.jpg',
        ]);
        $albumMayhem->tags()->attach([$tagRaw->id, $tagChaotic->id]);
        $albumMayhem->themes()->attach([$themeSatanism->id, $themeOccult->id]);
        $this->addTracks($albumMayhem, [
            ['Funeral Fog', 307], ['Cursed in Eternity', 310], ['Pagan Fears', 396],
            ['Freezing Moon', 383], ['Completement', 268], ['The Frost of Midgard', 228],
            ['A New Land', 409], ['De Mysteriis Dom Sathanas', 416],
        ]);

        // 3.2. Burzum - Filosofem (1996)
        $albumBurzum1 = Album::create([
            'artist_id' => $burzum->id, 'title' => 'Filosofem', 'slug' => 'filosofem',
            'release_year' => 1996, 'cover_image_path' => '/img/covers/burzum_filosofem.jpg',
        ]);
        $albumBurzum1->tags()->attach([$tagRaw->id, $tagAtmospheric->id, $tagDepressive->id]);
        $albumBurzum1->themes()->attach([$themeDepression->id, $themePaganism->id]);
        $this->addTracks($albumBurzum1, [
            ['Dunkelheit', 425], ['Jesus\' Tod', 569], ['Erblicket die Töchter des Firmaments', 750],
            ['Gebrechlichkeit I', 396], ['Rundtgåing av den transcendentale Egenbetens Støtte', 1438],
            ['Gebrechlichkeit II', 320]
        ]);


        // 3.4. Darkthrone - Transilvanian Hunger (1994)
        $albumDarkthrone1 = Album::create([
            'artist_id' => $darkthrone->id, 'title' => 'Transilvanian Hunger', 'slug' => 'transilvanian-hunger',
            'release_year' => 1994, 'cover_image_path' => '/img/covers/darkthrone.jpg',
        ]);
        $albumDarkthrone1->tags()->attach([$tagRaw->id, $tagDepressive->id]);
        $albumDarkthrone1->themes()->attach([$themePaganism->id]);
        $this->addTracks($albumDarkthrone1, [
            ['Transilvanian Hunger', 379], ['Over fjell og gjennom torner', 296], ['Skald av en Islagt Heim', 413],
            ['As Flittermice as Satans Spies', 355], ['En ås i dype skogen', 244], ['Vinterskugge', 279],
            ['Svart trone', 437], ['I en svart kiste', 374]
        ]);

        // 3.7. Emperor - In the Nightside Eclipse (1994)
        $albumEmperor = Album::create([
            'artist_id' => $emperor->id, 'title' => 'In the Nightside Eclipse', 'slug' => 'nightside-eclipse',
            'release_year' => 1994, 'cover_image_path' => '/img/covers/emperor.jpg',
        ]);
        $albumEmperor->tags()->attach([$tagEpicSynth->id, $tagMelodic->id, $tagSymphonic->id]);
        $albumEmperor->themes()->attach([$themeOccult->id, $themeSatanism->id]);
        $this->addTracks($albumEmperor, [
            ['Into the Infinity of Thoughts', 558], ['The Burning Shadows of Silence', 547],
            ['Cosmic Keys to My Creations & Times', 400], ['I Am the Black Wizards', 396],
            ['In the Nightside Eclipse', 214]
        ]);

        // 3.8. Dissection - Storm of the Light's Bane (1995)
        $albumDissection = Album::create([
            'artist_id' => $dissection->id, 'title' => 'Storm of the Light\'s Bane', 'slug' => 'storm-of-the-lights-bane',
            'release_year' => 1995, 'cover_image_path' => '/img/covers/dissection.jpg',
        ]);
        $albumDissection->tags()->attach([$tagMelodic->id]);
        $albumDissection->themes()->attach([$themeOccult->id]);
        $this->addTracks($albumDissection, [
            ['At the Fathomless Depths', 110], ['Night\'s Blood', 438], ['Unhallowed', 533],
            ['Where Dead Angels Lie', 399], ['Retribution - Storm of the Light\'s Bane', 506],
            ['Thorns of Crimson Death', 539], ['Soulreaper', 397], ['No Dreams Dare Shine', 214]
        ]);


        // === NEW BLACk METAL ALBUMS ===

        // 3.14. Gorgoroth - Antichrist (1996)
        $albumGorgoroth = Album::create([
            'artist_id' => $gorgoroth->id, 'title' => 'Antichrist', 'slug' => 'antichrist',
            'release_year' => 1996, 'cover_image_path' => '/img/covers/gorgoroth.jpg',
        ]);
        $albumGorgoroth->tags()->attach([$tagRaw->id, $tagChaotic->id]);
        $albumGorgoroth->themes()->attach([$themeSatanism->id]);
        $this->addTracks($albumGorgoroth, [
            ['En Stram Lukt Av Kristent Blod', 408], ['Bergtrollets Hevn', 246], ['Gorgoroth', 417],
            ['Possessed (Into Darkness)', 269], ['Heavens Fall', 239], ['Sorg', 361]
        ]);

        // 3.15. Enslaved - Vikingligr Veldi (1994)
        $albumEnslaved = Album::create([
            'artist_id' => $enslaved->id, 'title' => 'Vikingligr Veldi', 'slug' => 'vikingligr-veldi',
            'release_year' => 1994, 'cover_image_path' => '/img/covers/enslaved.jpg',
        ]);
        $albumEnslaved->tags()->attach([$tagViking->id, $tagAtmospheric->id]);
        $albumEnslaved->themes()->attach([$themePaganism->id]);
        $this->addTracks($albumEnslaved, [
            ['Lifandi lif undir Kveldrinu', 872], ['Vetrarnótt', 330], ['Midgards Eldar', 1146],
            ['Heimdallr', 270], ['Norvegr', 1056]
        ]);

        // 3.16. Watain - Lawless Darkness (2010)
        $albumWatain = Album::create([
            'artist_id' => $watain->id, 'title' => 'Lawless Darkness', 'slug' => 'lawless-darkness',
            'release_year' => 2010, 'cover_image_path' => '/img/covers/watain.jpg',
        ]);
        $albumWatain->tags()->attach([$tagChaotic->id, $tagMelodic->id]);
        $albumWatain->themes()->attach([$themeSatanism->id, $themeOccult->id]);
        $this->addTracks($albumWatain, [
            ['De Profundis', 101], ['Malfeitor', 292], ['Reaping Death', 247],
            ['Four Thrones', 457], ['Total Funeral', 234], ['Hymn to Qayin', 685]
        ]);

        // 3.17. Drudkh - Autumn Aurora (2004)
        $albumDrudkh = Album::create([
            'artist_id' => $drudkh->id, 'title' => 'Autumn Aurora', 'slug' => 'autumn-aurora',
            'release_year' => 2004, 'cover_image_path' => '/img/covers/drudkh.jpg',
        ]);
        $albumDrudkh->tags()->attach([$tagAtmospheric->id]);
        $albumDrudkh->themes()->attach([$themeForest->id, $themeDepression->id]);
        $this->addTracks($albumDrudkh, [
            ['Fading', 638], ['Summoning the Rain', 342], ['Glare of Autumn', 517],
            ['Sunwheel', 342], ['Wind of the Depths', 396]
        ]);

        // 3.18. Agalloch - The Mantle (2002)
        $albumAgalloch = Album::create([
            'artist_id' => $agalloch->id, 'title' => 'The Mantle', 'slug' => 'the-mantle',
            'release_year' => 2002, 'cover_image_path' => '/img/covers/agalloch.jpg',
        ]);
        $albumAgalloch->tags()->attach([$tagAtmospheric->id, $tagMelodic->id]);
        $albumAgalloch->themes()->attach([$themeForest->id, $themeDepression->id]);
        $this->addTracks($albumAgalloch, [
            ['A Celebration for the Death of Man', 288], ['In the Shadow of Our Pale Companion', 882],
            ['Odal', 497], ['I Am the Wooden Doors', 123], ['The Lodge', 368]
        ]);


        // === NU METAL ALBUMS ===

        // 3.19. Korn - Follow the Leader (1998)
        $albumKorn = Album::create([
            'artist_id' => $korn->id, 'title' => 'Follow the Leader', 'slug' => 'follow-the-leader',
            'release_year' => 1998, 'cover_image_path' => '/img/covers/korn.jpg',
        ]);
        $albumKorn->tags()->attach([$tagNuMetal->id]);
        $this->addTracks($albumKorn, [
            ['It\'s On!', 259], ['Freak on a Leash', 255], ['Got the Life', 204],
            ['Dead Bodies Everywhere', 294], ['Children of the Korn', 232], ['All in the Family', 264]
        ]);

        // 3.20. Slipknot - Iowa (2001)
        $albumSlipknot = Album::create([
            'artist_id' => $slipknot->id, 'title' => 'Iowa', 'slug' => 'iowa',
            'release_year' => 2001, 'cover_image_path' => '/img/covers/slipknot.jpg',
        ]);
        $albumSlipknot->tags()->attach([$tagNuMetal->id, $tagChaotic->id]);
        $this->addTracks($albumSlipknot, [
            ['(515)', 63], ['People = Shit', 222], ['Disasterpiece', 408],
            ['My Plague', 220], ['Everything Ends', 254], ['The Heretic Anthem', 254]
        ]);

        // 3.21. System of a Down - Toxicity (2001)
        $albumSoad = Album::create([
            'artist_id' => $soad->id, 'title' => 'Toxicity', 'slug' => 'toxicity',
            'release_year' => 2001, 'cover_image_path' => '/img/covers/soad.jpg',
        ]);
        $albumSoad->tags()->attach([$tagNuMetal->id, $tagChaotic->id]);
        $this->addTracks($albumSoad, [
            ['Prison Song', 201], ['Needles', 193], ['Deer Dance', 178],
            ['Jet Pilot', 171], ['X', 118], ['Chop Suey!', 210], ['Toxicity', 218]
        ]);

        // 3.22. Deftones - Around the Fur (1997)
        $albumDeftones2 = Album::create([
            'artist_id' => $deftones->id, 'title' => 'Around the Fur', 'slug' => 'around-the-fur',
            'release_year' => 1997, 'cover_image_path' => '/img/covers/deftones_fur.jpg',
        ]);
        $albumDeftones2->tags()->attach([$tagNuMetal->id, $tagAtmospheric->id]);
        $this->addTracks($albumDeftones2, [
            ['My Own Summer (Shove It)', 214], ['Lhabia', 250], ['Mascara', 225],
            ['Around the Fur', 230], ['Rickets', 165], ['Be Quiet and Drive (Far Away)', 308]
        ]);

        // 3.23. Satyricon - Nemesis Divina (1996)
        $albumSatyricon = Album::create([
            'artist_id' => $satyricon->id, 'title' => 'Nemesis Divina', 'slug' => 'nemesis-divina',
            'release_year' => 1996, 'cover_image_path' => '/img/covers/satyricon.jpg',
        ]);
        $albumSatyricon->tags()->attach([$tagSymphonic->id, $tagMelodic->id]);
        $albumSatyricon->themes()->attach([$themeSatanism->id]);
        $this->addTracks($albumSatyricon, [
            ['The Dawn of a New Age', 463], ['Forhekset', 289], ['Mother North', 305],
            ['Du som hater Gud', 250], ['Vikingland', 320]
        ]);


        // 3.24. Immortal - Diabolical Fullmoon Mysticism (1992)
        $albumImmortal = Album::create([
            'artist_id' => $immortal->id, 'title' => 'Diabolical Fullmoon Mysticism', 'slug' => 'diabolical-fullmoon-mysticism',
            'release_year' => 1992, 'cover_image_path' => '/img/covers/immortal_diabolical.jpg',
        ]);
        $albumImmortal->tags()->attach([$tagAtmospheric->id]);
        $albumImmortal->themes()->attach([$themePaganism->id]);
        $this->addTracks($albumImmortal, [
            ['Intro', 183], ['The Call of the Wintermoon', 340], ['Unsilent Storms in the Northark', 400],
            ['Pure Holocaust', 327], ['Blizzard Beasts', 246], ['A Perfect Vision of the Rising Northland', 255]
        ]);


        // --- Демо-записи (оставляем) ---
        Artist::create([
            'name' => 'Mystic Woods Demo', 'slug' => 'mystic-woods', 'country_id' => $us,
            'bio' => 'Неизвестный проект из лесов. Сырой, атмосферный блэк-метал.', 'formed_year' => 2024, 'is_underground' => true,
        ])->albums()->create([
            'title' => 'Ancient Whisper (Demo)', 'slug' => 'ancient-whisper-demo', 'release_year' => 2024,
            'cover_image_path' => '/img/covers/demo.jpg', 'is_demo' => true,
        ]);
    }

    /**
     * Вспомогательная функция для добавления треков к альбому.
     */
    protected function addTracks(Album $album, array $tracksData): void
    {
        foreach ($tracksData as $i => $track) {
            Track::create([
                'album_id' => $album->id,
                'title' => $track[0],
                'track_number' => $i + 1,
                'duration' => $track[1],
            ]);
        }
    }
}
