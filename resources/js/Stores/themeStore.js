import { defineStore } from 'pinia';

export const useThemeStore = defineStore('theme', {
    state: () => ({
        themes: {
            hindu: {
                primary: '#FF7722',
                secondary: '#FFA366',
                accent: '#FFE6D9',
                textPrimary: '#4A4A4A',
                background: '#FFF9F5'
            },
            muslim: {
                primary: '#2E7D32',
                secondary: '#66BB6A',
                accent: '#E8F5E9',
                textPrimary: '#4A4A4A',
                background: '#F5F9F5'
            },
            christian: {
                primary: '#1E88E5',
                secondary: '#64B5F6',
                accent: '#E3F2FD',
                textPrimary: '#4A4A4A',
                background: '#F5F9FF'
            },
            buddhist: {
                primary: '#FFC107',
                secondary: '#FFD54F',
                accent: '#FFF8E1',
                textPrimary: '#4A4A4A',
                background: '#FFFDF5'
            },
            default: {
                primary: '#5E72E4',
                secondary: '#8392AB',
                accent: '#F7FAFC',
                textPrimary: '#4A4A4A',
                background: '#FFFFFF'
            }
        },
        currentTheme: 'default'
    }),
    getters: {
        currentThemeColors: (state) => state.themes[state.currentTheme],
        cssVariables: (state) => {
            const theme = state.themes[state.currentTheme];
            return {
                '--primary': theme.primary,
                '--secondary': theme.secondary,
                '--accent': theme.accent,
                '--text-primary': theme.textPrimary,
                '--background': theme.background
            };
        }
    },
    actions: {
        setTheme(religion) {
            this.currentTheme = religion.toLowerCase() in this.themes ? religion.toLowerCase() : 'default';
        }
    }
}); 