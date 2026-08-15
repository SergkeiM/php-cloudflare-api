import type { ContentNavigationItem } from '@nuxt/content'

/**
 * The Client Reference lists one entry per top-level endpoint, in the order the
 * accessors happen to be registered on the client. That order is a record of
 * when each endpoint was built, which is of no use to somebody looking for the
 * one they need.
 *
 * These sections group them by what they do instead. Grouping happens here
 * rather than in the generated file tree because a folder per section would put
 * itself in every URL, turning `/client/dns` into `/client/zones-and-dns/dns`
 * and breaking every link already pointing at the old address.
 *
 * Sections render in the order given; endpoints render in the order listed
 * within a section. Anything not listed keeps its place at the end of the
 * sidebar rather than disappearing, so a newly added endpoint is visible even
 * before it is filed here.
 */
export const CLIENT_SECTIONS: { title: string, slugs: string[] }[] = [
    {
        title: 'Account & Identity',
        slugs: ['accounts', 'user', 'organizations', 'memberships', 'tenants', 'iam'],
    },
    {
        title: 'Zones & DNS',
        slugs: ['zones', 'dns', 'page-rules'],
    },
    {
        title: 'Security',
        slugs: ['rulesets', 'firewall', 'bot-management', 'ssl', 'origin-ca-certificates'],
    },
    {
        title: 'Performance',
        slugs: ['cache', 'load-balancers', 'cloud-connector', 'zaraz', 'google-tag-gateway'],
    },
    {
        title: 'Compute & Storage',
        slugs: ['workers', 'kv', 'durable-objects', 'd1', 'r2'],
    },
    {
        title: 'Network',
        slugs: ['zero-trust', 'ips'],
    },
]

/** The last path segment, which is the accessor slug the sections are keyed by. */
function slugOf(item: ContentNavigationItem): string {
    return (item.path || '').split('/').filter(Boolean).pop() || ''
}

/**
 * Fold the flat list of endpoints into the sections above.
 *
 * A section is a navigation item carrying children and no path of its own,
 * which the navigation component renders as a collapsible heading rather than
 * a link.
 */
export function groupClientNavigation(items: ContentNavigationItem[]): ContentNavigationItem[] {
    if (!items?.length) {
        return items || []
    }

    const bySlug = new Map<string, ContentNavigationItem>()

    for (const item of items) {
        const slug = slugOf(item)
        if (slug) {
            bySlug.set(slug, item)
        }
    }

    const grouped: ContentNavigationItem[] = []
    const claimed = new Set<string>()

    for (const section of CLIENT_SECTIONS) {
        const children = section.slugs
            .map((slug) => {
                const item = bySlug.get(slug)
                if (item) {
                    claimed.add(slug)
                }
                return item
            })
            .filter((item): item is ContentNavigationItem => Boolean(item))

        if (children.length) {
            grouped.push({ title: section.title, path: '', children } as ContentNavigationItem)
        }
    }

    // Nothing is dropped: an endpoint no section claims stays where it was.
    const unclaimed = items.filter(item => !claimed.has(slugOf(item)))

    return [...grouped, ...unclaimed]
}

/**
 * Apply the sections wherever the Client Reference turns up in the sidebar.
 *
 * Docus hands the aside either the endpoints themselves, when it is showing one
 * section's contents, or the whole tree with Client Reference as one node among
 * Getting Started and the rest. Both shapes arrive here.
 */
export function withGroupedClientNavigation(items: ContentNavigationItem[]): ContentNavigationItem[] {
    if (!items?.length) {
        return items || []
    }

    if (items.some(item => (item.path || '').startsWith('/client/'))) {
        return groupClientNavigation(items)
    }

    return items.map(item =>
        item.path === '/client' && item.children?.length
            ? { ...item, children: groupClientNavigation(item.children) }
            : item,
    )
}
