"use client";

import { useEffect, useState } from "react";
import Cookies from "js-cookie";
import { useRouter } from "next/navigation";

interface User {
    id: number;
    name: string;
    email: string;
    role: string;
}

export default function AdminPage() {
    const router = useRouter();
    const [user, setUser] = useState<User | null>(null);
    const [users, setUsers] = useState<User[]>([]);

    useEffect(() => {
        const checkAdmin = async () => {
            const token = Cookies.get("token");
            if (!token) return router.push("/");

            try {
                const res = await fetch(`${process.env.NEXT_PUBLIC_API_URL}/me`, {
                    headers: {
                        Authorization: `Bearer ${token}`,
                        Accept: "application/json",
                    },
                });

                if (!res.ok) throw new Error("Unauthorized");

                const data = await res.json();
                const currentUser = data.data;

                if (currentUser.role !== "admin") return router.push(`/${currentUser.role}`);

                setUser(currentUser);

                const usersRes = await fetch(`${ process.env.NEXT_PUBLIC_API_URL }/users`, {
                    headers: {
                        Authorization: `Bearer ${token}`,
                        Accept: "application/json",
                    },
                });

                if (usersRes.ok) {
                    const usersData = await usersRes.json();
                    setUsers(usersData.data);
                }
            } catch {
                router.push("/");
            }
        };

        checkAdmin();
    }, [router]);

    const handleDelete = async (id: number) => {
        const token = Cookies.get("token");
        if (!token) return;

        try {
            const res = await fetch(`${process.env.NEXT_PUBLIC_API_URL}/user/${id}`, {
                method: "DELETE",
                headers: {
                    Authorization: `Bearer ${token}`,
                    Accept: "application/json",
                },
            });

            if (res.ok) {
                setUsers(users.filter((u) => u.id !== id));
            } else {
                alert("Не удалось удалить пользователя.");
            }
        } catch (error) {
            alert("Произошла ошибка при удалении пользователя.");
        }
      };

    if (!user) {
        return (
            <div className="min-h-screen flex items-center justify-center bg-gray-100 px-4">
                <div className="p-6 bg-white shadow-md rounded text-center text-gray-800">
                    Загрузка...
                </div>
            </div>
        );
    }

    return (
        <div className="min-h-screen bg-gray-100 text-gray-900 px-6 py-10">
            <div className="max-w-7xl mx-auto space-y-10">
                <div>
                    <h2 className="text-4xl font-bold mb-2">Панель администратора</h2>
                    <p className="text-xl">Добро пожаловать, <strong>{user.name}</strong>!</p>
                </div>

                <div className="flex items-center justify-between">
                    <h3 className="text-2xl font-semibold pl-2 pt-2">Пользователи</h3>
                    <button
                        className="bg-blue-600 hover:bg-blue-700 text-white text-base font-medium py-3 px-6 rounded-lg transition"
                        onClick={() => router.push("/admin/users/create")}
                    >
                        Создать пользователя
                    </button>
                </div>

                <div className="overflow-x-auto rounded-xl shadow-lg">
                    <table className="min-w-full bg-white text-base">
                        <thead className="bg-gray-200 text-left">
                            <tr>
                                <th className="px-6 py-4">ID</th>
                                <th className="px-6 py-4">Имя</th>
                                <th className="px-6 py-4">Email</th>
                                <th className="px-6 py-4">Роль</th>
                                <th className="px-6 py-4">Действия</th>
                            </tr>
                        </thead>
                        <tbody className="divide-y">
                            {users.map((u) => (
                                <tr key={u.id} className="hover:bg-gray-50">
                                    <td className="px-6 py-4">{u.id}</td>
                                    <td className="px-6 py-4">{u.name}</td>
                                    <td className="px-6 py-4">{u.email}</td>
                                    <td className="px-6 py-4">{u.role}</td>
                                    <td className="px-6 py-4 flex flex-wrap gap-2">
                                        <button
                                            className="bg-yellow-400 hover:bg-yellow-500 text-white px-4 py-2 rounded text-sm font-semibold"
                                            onClick={() => router.push(`/admin/users/edit?id=${u.id}`)}
                                        >
                                            Редактировать
                                        </button>
                                        <button
                                            className="bg-indigo-500 hover:bg-indigo-600 text-white px-4 py-2 rounded text-sm font-semibold"
                                            onClick={() => router.push(`/admin/users/password?id=${u.id}`)}
                                        >
                                            Сбросить пароль
                                        </button>
                                        <button
                                            className="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded text-sm font-semibold"
                                            onClick={() => handleDelete(u.id)}
                                        >
                                            Удалить
                                        </button>
                                    </td>
                                </tr>
                            ))}
                        </tbody>
                    </table>
                </div>
            </div>
      </div>
    );
}
