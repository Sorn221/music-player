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
        // Очистка данных перед началом (важно для migrate:fresh)
        // В данном случае, migrate:fresh уже делает это, но на всякий случай
        // Artist::truncate(); Album::truncate(); и т.д.

        // Получение ID стран и тегов
        $norway = Country::where('name', 'Norway')->first()->id;
        $sweden = Country::where('name', 'Sweden')->first()->id;
        $us = Country::where('name', 'United States')->first()->id;
        $germany = Country::where('name', 'Germany')->first()->id;
        $poland = Country::where('name', 'Poland')->first()->id ?? 
            Country::create(['name' => 'Poland', 'slug' => 'poland'])->id;
        $uk = Country::where('name', 'United Kingdom')->first() ? 
            Country::where('name', 'United Kingdom')->first()->id : 
            Country::create(['name' => 'United Kingdom', 'slug' => 'united-kingdom'])->id;

        $tagRaw = Tag::where('slug', 'lo-fi-rawness')->first();
        $tagAtmospheric = Tag::where('slug', 'atmospheric')->first();
        $tagMelodic = Tag::where('slug', 'melodic')->first();
        $tagDepressive = Tag::where('slug', 'depressive')->first();
        $tagEpicSynth = Tag::where('slug', 'epic-synth')->first();
        $tagBlackgaze = Tag::where('slug', 'blackgaze')->first();
        $tagChaotic = Tag::where('slug', 'chaotic')->first() ?? 
            Tag::create(['name' => 'Chaotic', 'slug' => 'chaotic'])->first();

        $themeSatanism = Theme::where('slug', 'satanism-anti-christianity')->first();
        $themeForest = Theme::where('slug', 'forest-mysticism')->first();
        $themeDepression = Theme::where('slug', 'depression-isolation')->first();
        $themePaganism = Theme::where('slug', 'paganism-norse-mythology')->first();
        $themeOccult = Theme::where('slug', 'occult')->first() ?? 
            Theme::create(['name' => 'Occultism', 'slug' => 'occultism'])->first();

        // --- 1. Артисты ---
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
        $alcest = Artist::create(['name' => 'Alcest', 'slug' => 'alcest', 'country_id' => Country::where('name', 'France')->first()->id, 'formed_year' => 1999]);
        $deftones = Artist::create(['name' => 'Deftones', 'slug' => 'deftones', 'country_id' => $us, 'formed_year' => 1988]);
        
        // --- 2. Древо Эволюции (Influences) ---
        // I. Первая волна повлияла на Вторую
        $mayhem->influencers()->attach($bathory->id);
        $darkthrone->influencers()->attach($bathory->id);
        $immortal->influencers()->attach($bathory->id);
        
        // II. Норвежская сцена повлияла на шведскую и других
        $dissection->influencers()->attach($mayhem->id);
        $marduk->influencers()->attach($darkthrone->id);
        
        // III. Влияние на современную сцену
        $wolves->influencers()->attach($immortal->id);
        $alcest->influencers()->attach($emperor->id);


        // --- 3. Альбомы и Треки ---

        // 3.1. Mayhem - De Mysteriis Dom Sathanas (1994) (со всеми треками)
        $albumMayhem = Album::create([
            'artist_id' => $mayhem->id, 'title' => 'De Mysteriis Dom Sathanas', 'slug' => 'de-mysteriis-dom-sathanas',
            'release_year' => 1994, 'cover_image_path' => '/img/covers/mayhem.jpg',
        ]);
        $albumMayhem->tags()->attach([$tagRaw->id, $tagChaotic->id]);
        $albumMayhem->themes()->attach([$themeSatanism->id, $themeOccult->id]);
        
        $mayhemTracks = [
            ['Funeral Fog', 307], ['Cursed in Eternity', 310], ['Pagan Fears', 396], 
            ['Freezing Moon', 383], ['Completement', 268], ['The Frost of Midgard', 228], 
            ['A New Land', 409], ['De Mysteriis Dom Sathanas', 416],
        ];
        foreach ($mayhemTracks as $i => $track) {
            Track::create([
                'album_id' => $albumMayhem->id, 'title' => $track[0], 'track_number' => $i + 1, 'duration' => $track[1],
            ]);
        }
        
        // 3.2. Burzum - Filosofem (1996)
        $albumBurzum1 = Album::create([
            'artist_id' => $burzum->id, 'title' => 'Filosofem', 'slug' => 'filosofem',
            'release_year' => 1996, 'cover_image_path' => '/img/covers/burzum_filosofem.jpg',
        ]);
        $albumBurzum1->tags()->attach([$tagRaw->id, $tagAtmospheric->id, $tagDepressive->id]);
        $albumBurzum1->themes()->attach([$themeDepression->id, $themePaganism->id]);
        
        $burzumTracks1 = [['Dunkelheit', 425], ['Jesus\' Tod', 569], ['Erblicket die Töchter des Firmaments', 750]];
        foreach ($burzumTracks1 as $i => $track) {
            Track::create([
                'album_id' => $albumBurzum1->id, 'title' => $track[0], 'track_number' => $i + 1, 'duration' => $track[1],
            ]);
        }

        // 3.3. Burzum - Hvis Lyset Tar Oss (1994)
        $albumBurzum2 = Album::create([
            'artist_id' => $burzum->id, 'title' => 'Hvis Lyset Tar Oss', 'slug' => 'hvis-lyset',
            'release_year' => 1994, 'cover_image_path' => '/img/covers/burzum_hvis.jpg',
        ]);
        $albumBurzum2->tags()->attach([$tagRaw->id, $tagAtmospheric->id]);
        $albumBurzum2->themes()->attach([$themeDepression->id, $themeForest->id]);

        
        // 3.4. Darkthrone - Transilvanian Hunger (1994)
        $albumDarkthrone1 = Album::create([
            'artist_id' => $darkthrone->id, 'title' => 'Transilvanian Hunger', 'slug' => 'transilvanian-hunger',
            'release_year' => 1994, 'cover_image_path' => '/img/covers/darkthrone.jpg',
        ]);
        $albumDarkthrone1->tags()->attach([$tagRaw->id, $tagDepressive->id]);
        $albumDarkthrone1->themes()->attach([$themePaganism->id]);

        // 3.5. Darkthrone - A Blaze in the Northern Sky (1992)
        $albumDarkthrone2 = Album::create([
            'artist_id' => $darkthrone->id, 'title' => 'A Blaze in the Northern Sky', 'slug' => 'a-blaze-in-the-northern-sky',
            'release_year' => 1992, 'cover_image_path' => '/img/covers/darkthrone_blaze.jpg',
        ]);
        $albumDarkthrone2->tags()->attach([$tagRaw->id, $tagChaotic->id]);
        $albumDarkthrone2->themes()->attach([$themeSatanism->id]);


        // 3.6. Immortal - Battles in the North (1995)
        $albumImmortal = Album::create([
            'artist_id' => $immortal->id, 'title' => 'Battles in the North', 'slug' => 'battles-in-the-north',
            'release_year' => 1995, 'cover_image_path' => '/img/covers/immortal.jpg',
        ]);
        $albumImmortal->tags()->attach([$tagChaotic->id, $tagRaw->id]);
        $albumImmortal->themes()->attach([$themePaganism->id]);


        // 3.7. Emperor - In the Nightside Eclipse (1994)
        $albumEmperor = Album::create([
            'artist_id' => $emperor->id, 'title' => 'In the Nightside Eclipse', 'slug' => 'nightside-eclipse',
            'release_year' => 1994, 'cover_image_path' => '/img/covers/emperor.jpg',
        ]);
        $albumEmperor->tags()->attach([$tagEpicSynth->id, $tagMelodic->id]);
        $albumEmperor->themes()->attach([$themeOccult->id, $themeSatanism->id]);


        // 3.8. Dissection - Storm of the Light's Bane (1995)
        $albumDissection = Album::create([
            'artist_id' => $dissection->id, 'title' => 'Storm of the Light\'s Bane', 'slug' => 'storm-of-the-lights-bane',
            'release_year' => 1995, 'cover_image_path' => '/img/covers/dissection.jpg',
        ]);
        $albumDissection->tags()->attach([$tagMelodic->id]);
        $albumDissection->themes()->attach([$themeOccult->id]);


        // 3.9. Behemoth - The Satanist (2014)
        $albumBehemoth = Album::create([
            'artist_id' => $behemoth->id, 'title' => 'The Satanist', 'slug' => 'the-satanist',
            'release_year' => 2014, 'cover_image_path' => '/img/covers/behemoth.jpg',
        ]);
        $albumBehemoth->tags()->attach([$tagMelodic->id, $tagEpicSynth->id]);
        $albumBehemoth->themes()->attach([$themeSatanism->id]);


        // 3.10. Cradle of Filth - Dusk... and Her Embrace (1996)
        $albumCoF = Album::create([
            'artist_id' => $cradleoffilth->id, 'title' => 'Dusk... and Her Embrace', 'slug' => 'dusk-and-her-embrace',
            'release_year' => 1996, 'cover_image_path' => '/img/covers/cof.jpg',
        ]);
        $albumCoF->tags()->attach([$tagEpicSynth->id, $tagMelodic->id]);
        $albumCoF->themes()->attach([$themeOccult->id]);

        // 3.11. Wolves in the Throne Room - Two Hunters (2007)
        $albumWolves = Album::create([
            'artist_id' => $wolves->id, 'title' => 'Two Hunters', 'slug' => 'two-hunters',
            'release_year' => 2007, 'cover_image_path' => '/img/covers/wittr.jpg',
        ]);
        $albumWolves->tags()->attach([$tagAtmospheric->id, $tagMelodic->id, $tagBlackgaze->id]);
        $albumWolves->themes()->attach([$themeForest->id]);


        // 3.12. Deftones - White Pony (2000) (для проверки системы рекомендаций с не-BM)
        $albumDeftones = Album::create([
            'artist_id' => $deftones->id, 'title' => 'White Pony', 'slug' => 'white-pony',
            'release_year' => 2000, 'cover_image_path' => '/img/covers/deftones.jpg',
        ]);
        $albumDeftones->tags()->attach([$tagMelodic->id]);

        
        // 3.13. Демо-записи
        Artist::create([
            'name' => 'Mystic Woods Demo', 'slug' => 'mystic-woods', 'country_id' => $us,
            'bio' => 'Неизвестный проект из лесов.', 'formed_year' => 2024, 'is_underground' => true,
        ])->albums()->create([
            'title' => 'Ancient Whisper (Demo)', 'slug' => 'ancient-whisper-demo', 'release_year' => 2024,
            'cover_image_path' => '/img/covers/demo.jpg', 'is_demo' => true,
        ]);
    }
}