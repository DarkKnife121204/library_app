'use client'
import { useRouter } from 'next/navigation'
import { useState } from 'react'

export default function LoginPage() {
    const router = useRouter()
    const [email, setEmail] = useState('')
    const [password, setPassword] = useState('')

    const handleLogin = async (e: React.FormEvent) => {
        e.preventDefault()

        try {
            const res = await fetch('http://localhost:80/api/login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                credentials: 'include',
                body: JSON.stringify({ email, password })
            })

            if (!res.ok) throw new Error('Ошибка при входе')

            const data = await res.json()

            localStorage.setItem('role', data.role)

            router.push(`/${data.role}`)
        } catch (err) {
            alert(err)
        }
      }

    return (
        <div className="flex min-h-screen justify-center items-center bg-gray-100">
            <form onSubmit={handleLogin} className="flex flex-col gap-4 p-6 bg-white shadow-md rounded w-80">
                <h2 className="text-xl font-bold text-center text-gray-800">Вход</h2>
                <input
                    className="border px-3 py-2 rounded text-gray-800"
                    type="email"
                    placeholder="Email"
                    value={email}
                    onChange={e => setEmail(e.target.value)}
                />
                <input
                    className="border px-3 py-2 rounded text-gray-800"
                    type="password"
                    placeholder="Пароль"
                    value={password}
                    onChange={e => setPassword(e.target.value)}
                />
                <button type="submit" className="bg-blue-600 text-white px-3 py-2 rounded hover:bg-blue-700">
                    Войти
                </button>
            </form>
        </div>
    )
}
