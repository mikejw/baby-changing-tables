import { Head, useForm, usePage } from '@inertiajs/react'
export default function Login() {
  const { appName = 'Feeder' } = usePage().props
  const { data, setData, post, processing, errors } = useForm({
    email: '',
    password: '',
    remember: false,
  })
  const submit = (e) => {
    e.preventDefault()
    post('/login')
  }
  const firstError = errors.email || errors.password
  return (
    <>
      <Head title={`${appName} — Sign in`} />
      <div className="flex min-h-screen items-center justify-center px-6 py-12">
        <div className="w-full max-w-sm">
          <div className="mb-8 text-center">
            <h1 className="text-2xl font-semibold tracking-tight">{appName} (Inertia)</h1>
            <p className="mt-2 text-sm text-[#706f6c] dark:text-[#A1A09A]">
              Sign in to view feed history.
            </p>
          </div>
          <div className="rounded-lg border border-[#19140035] bg-white p-6 shadow-sm dark:border-[#3E3E3A] dark:bg-[#161615]">
            <form onSubmit={submit} className="space-y-4">
              <div>
                <label htmlFor="email" className="mb-1 block text-sm font-medium">
                  Email
                </label>
                <input
                  id="email"
                  name="email"
                  type="email"
                  autoComplete="email"
                  required
                  autoFocus
                  value={data.email}
                  onChange={(e) => setData('email', e.target.value)}
                  className="block w-full rounded-md border border-[#19140035] bg-white px-3 py-2 text-sm text-[#1b1b18] placeholder-[#706f6c] focus:border-[#1b1b18] focus:outline-none focus:ring-1 focus:ring-[#1b1b18] dark:border-[#3E3E3A] dark:bg-[#0a0a0a] dark:text-[#EDEDEC] dark:focus:border-[#EDEDEC] dark:focus:ring-[#EDEDEC]"
                />
              </div>
              <div>
                <label htmlFor="password" className="mb-1 block text-sm font-medium">
                  Password
                </label>
                <input
                  id="password"
                  name="password"
                  type="password"
                  autoComplete="current-password"
                  required
                  value={data.password}
                  onChange={(e) => setData('password', e.target.value)}
                  className="block w-full rounded-md border border-[#19140035] bg-white px-3 py-2 text-sm text-[#1b1b18] placeholder-[#706f6c] focus:border-[#1b1b18] focus:outline-none focus:ring-1 focus:ring-[#1b1b18] dark:border-[#3E3E3A] dark:bg-[#0a0a0a] dark:text-[#EDEDEC] dark:focus:border-[#EDEDEC] dark:focus:ring-[#EDEDEC]"
                />
              </div>
              <label className="flex items-center gap-2 text-sm text-[#706f6c] dark:text-[#A1A09A]">
                <input
                  type="checkbox"
                  name="remember"
                  checked={data.remember}
                  onChange={(e) => setData('remember', e.target.checked)}
                  className="h-4 w-4 rounded border-[#19140035] dark:border-[#3E3E3A]"
                />
                Remember me
              </label>
              {firstError ? (
                <div className="rounded-md border border-red-200 bg-red-50 px-3 py-2 text-sm text-red-700 dark:border-red-900/50 dark:bg-red-950/40 dark:text-red-300">
                  {firstError}
                </div>
              ) : null}
              <button
                type="submit"
                disabled={processing}
                className="w-full rounded-md bg-[#1b1b18] px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-black disabled:cursor-not-allowed disabled:opacity-70 dark:bg-[#EDEDEC] dark:text-[#1b1b18] dark:hover:bg-white"
              >
                {processing ? 'Signing in...' : 'Sign in'}
              </button>
            </form>
          </div>
        </div>
      </div>
    </>
  )
}