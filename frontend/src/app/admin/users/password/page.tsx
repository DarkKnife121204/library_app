'use client'

import { useSearchParams, useRouter } from 'next/navigation'
import { useState, useEffect } from 'react'
import Cookies from 'js-cookie'

export default function ResetPasswordPage() {
    const router = useRouter()

    const searchParams = useSearchParams()
    const userId = searchParams.get('id')
    const [password, setPassword] = useState('')

    const [authorized, setAuthorized] = useState(false)

    useEffect(() => {
        const checkAdmin = async () => {
            const token = Cookies.get('token')
            if (!token) return router.push('/')

            try {
                const res = await fetch(`${process.env.NEXT_PUBLIC_API_URL}/me`, {
                    headers: {
                        Authorization: `Bearer ${token}`,
                        Accept: 'application/json',
                    },
                })

                if (!res.ok) throw new Error('Unauthorized')

                const data = await res.json()
                const user = data.data

                if (user.role !== 'admin') return router.push(`/${user.role}`)

                setAuthorized(true)
            } catch {
                router.push('/')
            }
        }

        checkAdmin()
    }, [router])

    const handleSubmit = async (e: React.FormEvent) => {
        e.preventDefault()
        const token = Cookies.get('token')

        const res = await fetch(
            `${process.env.NEXT_PUBLIC_API_URL}/user/password/${userId}`,
            {
                method: 'PATCH',
                headers: {
                    Authorization: `Bearer ${token}`,
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ password }),
            }
        )

        if (res.ok) {
            alert('Пароль обновлён')
            router.push('/admin')
        } else {
            alert('Ошибка при обновлении пароля')
        }
    }

    if (!authorized) {
        return (
            <div className="min-h-screen flex items-center justify-center bg-gray-100 px-4">
                <div className="p-6 bg-white shadow-md rounded text-center text-gray-800">
                    Загрузка...
                </div>
            </div>
        )
    }

    return (
        <div className="min-h-screen flex items-center justify-center bg-gray-100 px-4">
            <form
                onSubmit={handleSubmit}
                className="w-full max-w-md bg-white p-6 rounded-xl shadow-lg flex flex-col gap-4"
            >
                <h2 className="text-2xl font-bold text-center text-gray-800">Сброс пароля</h2>

                <input
                    type="password"
                    placeholder="Новый пароль"
                    value={password}
                    onChange={(e) => setPassword(e.target.value)}
                    className="w-full border border-gray-300 rounded px-3 py-2 text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500"
                />

                <button
                    type="submit"
                    className="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded font-semibold transition"
                >
                    Обновить пароль
                </button>

                <button
                    type="button"
                    className="w-full bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded font-semibold transition"
                    onClick={() => router.push('/admin')}
                >
                    Назад в панель
                </button>
            </form>
        </div>
    )
}
