// public/js/player.js

const Player = {
    // DOM Элементы
    elements: {
        player: document.getElementById('mini-player'),
        audio: document.getElementById('audio-element'),
        cover: document.getElementById('player-cover'),
        title: document.getElementById('player-title'),
        artist: document.getElementById('player-artist'),
        playPauseBtn: document.getElementById('btn-play-pause'),
        icon: document.getElementById('btn-play-pause').querySelector('i'),
        progress: document.getElementById('player-progress'),
        currentTime: document.getElementById('player-time-current'),
        totalTime: document.getElementById('player-time-total'),
        nextBtn: document.getElementById('btn-next'),
        prevBtn: document.getElementById('btn-prev'),
        volume: document.getElementById('player-volume'),
    },

    // Состояние плеера
    state: {
        isPlaying: false,
        currentTrackIndex: 0,
        playlist: [],
        currentTrack: null,
    },

    // --- ИНИЦИАЛИЗАЦИЯ ---
    init() {
        this.bindEvents();
        // Устанавливаем громкость по умолчанию
        this.elements.audio.volume = 0.5;
        this.elements.volume.value = 50;
    },

    // --- ОБРАБОТЧИКИ СОБЫТИЙ ---
    bindEvents() {
        this.elements.playPauseBtn.addEventListener('click', () => this.togglePlayPause());
        this.elements.audio.addEventListener('loadedmetadata', () => this.handleLoadedMetadata());
        this.elements.audio.addEventListener('timeupdate', () => this.handleTimeUpdate());
        this.elements.audio.addEventListener('ended', () => this.playNext());
        this.elements.progress.addEventListener('input', (e) => this.handleSeek(e.target.value));
        this.elements.nextBtn.addEventListener('click', () => this.playNext());
        this.elements.prevBtn.addEventListener('click', () => this.playPrev());
        this.elements.volume.addEventListener('input', (e) => this.setVolume(e.target.value));
    },

    // --- ФУНКЦИИ ВОСПРОИЗВЕДЕНИЯ ---
    togglePlayPause() {
        if (!this.state.currentTrack) return;

        if (this.state.isPlaying) {
            this.elements.audio.pause();
        } else {
            this.elements.audio.play();
        }
        this.state.isPlaying = !this.state.isPlaying;
        this.updatePlayPauseButton();
    },

    updatePlayPauseButton() {
        this.elements.icon.className = this.state.isPlaying ? 'fas fa-pause' : 'fas fa-play';
    },

    loadTrack(track) {
        this.state.currentTrack = track;
        this.elements.audio.src = track.audio_url;

        // Обновляем информацию в плеере
        this.elements.cover.src = track.cover_url;
        this.elements.title.textContent = track.title;
        this.elements.artist.textContent = track.artist + ' - ' + track.album;
        if (this.elements.player.style.display === 'none') {
            this.elements.player.style.display = 'flex';
        }
        // Сбрасываем прогресс и время
        this.elements.audio.currentTime = 0;
        this.elements.progress.value = 0;

        this.elements.audio.play()
            .then(() => {
                this.state.isPlaying = true;
                this.updatePlayPauseButton();
            })
            .catch(error => {
                console.error("Ошибка при попытке воспроизвести аудио:", error);
                alert("Не удалось воспроизвести аудио (проверьте URL или настройки браузера)");
            });
    },

    // --- ПЛЕЙЛИСТ ---

    setPlaylistAndPlay(playlist, startIndex = 0) {
        this.state.playlist = playlist;
        this.state.currentTrackIndex = startIndex;
        this.loadTrack(playlist[startIndex]);
    },

    playNext() {
        if (this.state.playlist.length === 0) return;

        this.state.currentTrackIndex = (this.state.currentTrackIndex + 1) % this.state.playlist.length;
        this.loadTrack(this.state.playlist[this.state.currentTrackIndex]);
    },

    playPrev() {
        if (this.state.playlist.length === 0) return;

        let index = this.state.currentTrackIndex - 1;
        if (index < 0) {
            index = this.state.playlist.length - 1; // Циклическое воспроизведение
        }
        this.state.currentTrackIndex = index;
        this.loadTrack(this.state.playlist[this.state.currentTrackIndex]);
    },

    // --- ОБРАБОТКА МЕТАДАННЫХ/ВРЕМЕНИ ---

    formatTime(seconds) {
        const minutes = Math.floor(seconds / 60);
        const secs = Math.floor(seconds % 60);
        return minutes + ':' + (secs < 10 ? '0' : '') + secs;
    },

    handleLoadedMetadata() {
        const totalDuration = this.elements.audio.duration;
        this.elements.totalTime.textContent = this.formatTime(totalDuration);
        this.elements.progress.max = totalDuration;
    },

    handleTimeUpdate() {
        const current = this.elements.audio.currentTime;
        const total = this.elements.audio.duration;
        this.elements.currentTime.textContent = this.formatTime(current);
        this.elements.progress.value = current;
    },

    handleSeek(value) {
        this.elements.audio.currentTime = value;
    },

    setVolume(value) {
        this.elements.audio.volume = value / 100;
    }
};

document.addEventListener('DOMContentLoaded', () => {
    Player.init();

    // Делаем объект Player глобальным, чтобы его можно было вызывать из Blade-шаблонов
    window.AppPlayer = Player;
});
