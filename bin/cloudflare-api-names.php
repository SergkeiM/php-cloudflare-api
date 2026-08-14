<?php

/**
 * Prettier labels for the resource each Cloudflare path names, where the path
 * segment alone reads badly — acronyms it would title-case wrong, and internal
 * names that mean nothing to a reader.
 *
 * Cosmetic only: every count on the coverage page comes from the schema and the
 * endpoint classes. A resource with no entry here falls back to its path
 * segment, title-cased.
 */

return [
    'access' => 'Zero Trust Access',
    'acm' => 'Total TLS (ACM)',
    'ai' => 'Workers AI',
    'ai-audit' => 'AI Audit',
    'ai-gateway' => 'AI Gateway',
    'ai-search' => 'AI Search',
    'ai-security' => 'AI Security',
    'api_gateway' => 'API Gateway',
    'certificates' => 'Origin CA Certificates',
    'cfd_tunnel' => 'Cloudflare Tunnel',
    'cni' => 'Network Interconnects',
    'ct' => 'Certificate Transparency',
    'custom_csrs' => 'Custom CSRs',
    'custom_ns' => 'Custom Nameservers',
    'd1' => 'D1',
    'dcv_delegation' => 'DCV Delegation',
    'dex' => 'Digital Experience Monitoring',
    'dls' => 'DLS',
    'dlp' => 'DLP',
    'dns_analytics' => 'DNS Analytics',
    'dns_firewall' => 'DNS Firewall',
    'dns_records' => 'DNS Records',
    'dns_settings' => 'DNS Settings',
    'dnssec' => 'DNSSEC',
    'event_notifications' => 'R2 Event Notifications',
    'gateway' => 'Zero Trust Gateway',
    'hold' => 'Zone Holds',
    'iam' => 'IAM',
    'ips' => 'IPs',
    'logs' => 'Logpull',
    'magic' => 'Magic Transit & WAN',
    'managed_headers' => 'Managed Transforms',
    'mnm' => 'Magic Network Monitoring',
    'moq' => 'MoQ',
    'mtls_certificates' => 'mTLS Certificates',
    'oauth' => 'OAuth',
    'oauth_clients' => 'OAuth Clients',
    'origin_tls_client_auth' => 'Origin TLS Client Auth',
    'page_shield' => 'Page Shield',
    'pagerules' => 'Page Rules',
    'pcaps' => 'PCAPs',
    'profile' => 'Account Profile',
    'purge_cache' => 'Cache Purge',
    'r2' => 'R2',
    'r2-catalog' => 'R2 Data Catalog',
    'rum' => 'Web Analytics',
    'scim' => 'SCIM',
    'secondary_dns' => 'Secondary DNS',
    'settings' => 'Zone Settings',
    'speed_api' => 'Speed',
    'sso_connectors' => 'SSO Connectors',
    'ssl' => 'SSL/TLS',
    'storage' => 'Workers KV',
    'teamnet' => 'Tunnel Routing',
    'url_normalization' => 'URL Normalization',
    'urlscanner' => 'URL Scanner',
    'vuln_scanner' => 'Vulnerability Scanner',
    'warp_connector' => 'WARP Connector',
    'zerotrust' => 'Zero Trust',
    'zt_risk_scoring' => 'Zero Trust Risk Scoring',
];
