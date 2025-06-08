"use client";

import { useEffect, useState } from "react";
import { useRouter, useSearchParams } from "next/navigation";
import Cookies from "js-cookie";

export default function EditUserPage() {
    const router = useRouter();
    const searchParams = useSearchParams();
    const userId = searchParams.get("id");

    const [name, setName] = useState("");
    const [email, setEmail] = useState("");
    const [role, setRole] = useState("user");
    const [authorized, setAuthorized] = useState(false);

    useEffect(() => {
        const checkAdmin = async () => {
            const token = Cookies.get("token");
            if (!token) return router.push("/");

            try {
                const res = await fetch(`${ process.env.NEXT_PUBLIC_API_URL }/me`, {
                    headers: {
                        Authorization: `Bearer ${token}`,
                        Accept: "application/json",
                    },
                });

                if (!res.ok) throw new Error("Unauthorized");

                const data = await res.json();
                const user = data.data;

                if (user.role !== "admin") return router.push(`/${user.role}`);

                setAuthorized(true);
            } catch {
                router.push("/");
            }
        };

        const fetchUser = async () => {
            const token = Cookies.get("token");
            const res = await fetch(`${process.env.NEXT_PUBLIC_API_URL}/user/${userId}`, {
                headers: {
                    Authorization: `Bearer ${token}`,
                    Accept: "application/json",
                },
            });

            if (res.ok) {
                const data = await res.json();
                const user = data.data;
                setName(user.name);
                setEmail(user.email);
                setRole(user.role);
            } else {
                router.push("/admin");
            }
        };

        checkAdmin();
        fetchUser();
    }, [router, userId]);

    const handleSubmit = async (e: React.FormEvent) => {
        e.preventDefault();
        const token = Cookies.get("token");
        const res = await fetch(`${process.env.NEXT_PUBLIC_API_URL}/user/${userId}`, {
            method: "PATCH",
            headers: {
                Authorization: `Bearer ${token}`,
                "Content-Type": "application/json",
            },
            body: JSON.stringify({ name, email, role }),
        });

        if (res.ok) {
            router.push("/admin");
        } else {
            alert("Ошибка при обновлении пользователя");
        }
    };

    if (!authorized) {
        return (
            <div className="min-h-screen flex items-center justify-center bg-gray-100 px-4">
                <div className="p-6 bg-white shadow-md rounded text-center text-gray-800">
                    Проверка доступа...
                </div>
            </div>
        )
    }

    return (
        <div className="min-h-screen flex justify-center items-center bg-gray-100 px-4 py-10">
            <form
                onSubmit={handleSubmit}
                className="w-full max-w-lg bg-white rounded-xl shadow-lg p-8 space-y-6"
            >
                <h2 className="text-3xl font-bold text-gray-800 text-center">
                    Редактирование пользователя
                </h2>

                <input
                    type="text"
                    placeholder="Имя"
                    value={name}
                    onChange={(e) => setName(e.target.value)}
                    className="w-full border border-gray-300 px-4 py-3 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500"
                />

                <input
                    type="email"
                    placeholder="Email"
                    value={email}
                    onChange={(e) => setEmail(e.target.value)}
                    className="w-full border border-gray-300 px-4 py-3 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500"
                />

                <select
                    value={role}
                    onChange={(e) => setRole(e.target.value)}
                    className="w-full border border-gray-300 px-4 py-3 rounded-md text-gray-900 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                    <option value="user">Пользователь</option>
                    <option value="admin">Администратор</option>
                    <option value="librarian">Библиотекарь</option>
                </select>

                <div className="flex flex-col sm:flex-row gap-4">
                    <button
                        type="submit"
                        className="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-md transition"
                    >
                        Обновить
                    </button>

                    <button
                        type="button"
                        onClick={() => router.push("/admin")}
                        className="w-full bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-3 rounded-md transition"
                    >
                        Назад в панель
                    </button>
                </div>
            </form>
        </div>
    );
}
